<?php
// namespace Controller\V1;

use Fuel\Core\Controller_Rest;
use \Model\V1\User;
/**
 * The User Controller version v1.
 *
 * It controls all requests of API endpoints that configed in routes.php.
 *
 * @package  app
 * @extends  Controller_Rest
 * @author Vu Truong
 * @since 2014/10/30
 */
class Controller_V1_User extends Controller_Rest {

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
		
		// TODO: Validate input data
		// Create a new validation instance
		$val = Validation::forge('user');
		
		// Set rules for input fields
		$val->add_field('username', 'Username', 'required|trim|valid_string[alpha,lowercase,numeric]');
		$val->add_field('password', 'Password', 'required|trim|valid_string[alpha,lowercase,numeric]');
		$val->add_field('firstname', 'First name', 'required');
		$val->add_field('lastname', 'Last name', 'required');
		$val->add_field('email', 'Email', 'required|trim|valid_email');
		
		// Run validation on POST, if failed
		if (!$val->run()) {
			// Set error code and message
			$code = _ERROR_CODE_VALIDATE_FAILED_;
			// Get default FuelPHP error messages
			$message = $val->show_errors();

			// Return the validation result
			return $this->response(
				array(
					'meta' => array('code' => $code, 'message' => $message),
					'data' => null
				)
			);
		}
			
		// TODO: Check account existed

		// TODO: Insert new account
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
		return $this->response(array('user_id' => $user_id));
	}
}
