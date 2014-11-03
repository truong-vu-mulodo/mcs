<?php
// namespace Controller;

// use Fuel\Core\Controller_Rest;
use \Model\V1\User;

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
			$validate_result = $this->validate_input();
			
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
								'description' => "Account existed.",
								'messages' => $errors
						),
						'data' => null
				);
			}
			
			// Insert new account
			$user_id = User::create_acount(
					array(
							'username' => Input::post('username'),
							'password' => Input::post('password'),
							'firstname' => Input::post('firstname'),
							'lastname' => Input::post('lastname'),
							'email' => Input::post('email')
					)
			);
			
			// TODO: Create token
			// TODO: Update token to user table
			
			// Return created user id (record id)
			return $this->response(array('user_id' => null));
			
		} catch (Exception $e) {
			//Write log here
				
			// Return error info to response
			return parent::get_system_error_response();
		}
	}
	
	/**
	 * Validate input data.
	 * 
	 * @return array Error data including error message list
	 */
	private function validate_input() {
		try {
			// Create a new validation instance
			$val = Validation::forge('user');

			// Set rules for input fields
			$val->add_field('username', 'Username', 'required|trim|valid_string[alpha,lowercase,numeric]|min_length[4]|max_length[40]');
			$val->add_field('password', 'Password', 'required|trim|valid_string[alpha,lowercase,numeric]|max_length[40]');
			$val->add_field('firstname', 'First name', 'required|max_length[40]');
			$val->add_field('lastname', 'Last name', 'required|max_length[40]');
			$val->add_field('email', 'Email', 'required|trim|valid_email|max_length[255]');

			// Overwrite the default rule error messages
			$val->set_message('required', _DATA_REQUIRED_MSG_);
			$val->set_message('valid_string', _DATA_INVALID_MSG_.' Only lowercase alphanumeric is accepted.');
			$val->set_message('valid_email', _DATA_INVALID_MSG_);
			
			// Run validation on POST, if failed
			if (!$val->run()) {
				// Create the error message list
				$errors = array();
				foreach ($val->error() as $field => $error) {
					$errors[] = array(
							'message' => $error->get_message()
					);
			
				}
				// Return errors
				return array(
						'meta' => array(
								'code' => _VALIDATE_FAILED_CODE_,
								'description' => "Input validation failed.",
								'messages' => $errors
						),
						'data' => null
				);
			
			}
			// Validated OK
			return true;
		} catch (Exception $e) {
			//Write log
			Ultility_Log::log(Fuel::L_ERROR, $e, $method = "validate_input()");
			// Return error info to response
			return parent::get_system_error_response();
		}
	}
}