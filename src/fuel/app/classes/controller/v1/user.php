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
		
		$user_id = User::create_acount(
				array(
					'username' => Input::post('username'),
					'password' => Input::post('password'),
					'firstname' => Input::post('firstname'),
					'lastname' => Input::post('lastname'),
					'email' => Input::post('email')		
				)
		);

		// Return created user id (record id)
		return $this->response(array('user_id' => $user_id));
	}
}
