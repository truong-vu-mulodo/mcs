<?php
// namespace Controller;

use \Model\V1\User;
use \Model\V1\LoginSession;

/**
 * The User Controller version v1.
 *
 * It controls all requests of API endpoints that configed in routes.php.
 *
 * @package  app
 * @extends  Controller_V1_Base
 * @author Vu Truong
 * @since 2014/10/30
 */
class Controller_V1_User extends Controller_V1_Base {

	/**
	 * The API request with HTTP POST method.
	 * 
	 * This will create a new user account from provided information.
	 * 
	 * Ref endpoint: POST /v1/users
	 *
	 * @access  public
	 * @return  Response
	 */
	public function post_create() {
		try {
			// Validate input data
			$validate_result = User::validate_input();
			
			// If validate failed, return errors
			if ($validate_result !== true) {
				return $this->response($validate_result);
			}
			
			// Check account existed
			if (User::is_existed(Input::post('username'))) {
				// Set error message
				$errors = array('message' => 'This username is already in used.');
				// Return error
				return array(
						'meta' => array(
								'code' => _USERNAME_EXISTED_CODE_,
								'description' => _ACCOUNT_EXISTED_MSG_,
								'messages' => $errors
						),
						'data' => null
				);
			}

			// IMPORTANT: We need to be sure that login_session data is inserted only and
			// only once user data was inserted successfully.
			// Start transaction
			DB::start_transaction();
			
			// Insert new account
			$user_id = User::create_acount(
					array(
							'username' => Input::post('username'),
							'password' => md5(Input::post('password')),
							'firstname' => Input::post('firstname'),
							'lastname' => Input::post('lastname'),
							'email' => Input::post('email')
					)
			);
			
			// Create token (do login)
			// Crypt string "secrectkey@access_id@user_id@Date(UNIX TIME)" to create token
			$token = _ENCRYPT_SECRETE_KEY_."@access_id@$user_id@".time();
			$cipher = new Ultility_Cipher(_ENCRYPT_SECRETE_KEY_);
			$encrypt_token = $cipher->encrypt($token);

			// Insert new login session login_session table
			$session_id = LoginSession::create_login_session(
					array(
							'user_id' => $user_id,
							'access_token' => $encrypt_token
					)
			);

			// Commit transaction
			DB::commit_transaction();
			
			// Get created access token
			$access_token = LoginSession::get_access_token($session_id);
			
			// Get back created user info
			$user_info = User::get_user_info($user_id);
			
			// Add access token
			$user_info['access_token'] = $access_token;
			
			// Return created user info
			return $this->response(
						array(
							'meta' => array(
									'code' => _API_CALL_SUCCESS_CODE_,
									'description' => _USER_CREATED_SUCCESS_MSG_,
									'messages' => _USER_CREATED_SUCCESS_MSG_
							),
							'data' => $user_info
						)
					);
			
		} catch (Database_Exception $e) {
			// Rollback pending transactional queries
			DB::rollback_transaction();
			
			//Write log
			Ultility_Log::log(Fuel::L_ERROR, $e, $method = "post_create()");
			// Return error info to response
			return parent::get_error_response(_DATABASE_ERROR_TYPE_);
			
		} catch (Exception $e) {
			// Rollback pending transactional queries
			DB::rollback_transaction();
			
			//Write log
			Ultility_Log::log(Fuel::L_ERROR, $e, $method = "post_create()");
			// Return error info to response
			return parent::get_error_response(_SYSTEM_ERROR_TYPE_);
		}
	}
}