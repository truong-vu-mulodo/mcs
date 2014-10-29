<?php
/**
 * The User Controller version v1.
 *
 * It controls all requests of API endpoints that configed in routes.php.
 *
 * @package  app
 * @extends  Controller
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
		return $this->response(
			array(
				'username' => Input::post('username')." v1",
				'password' => Input::post('password'),
				'firstname' => Input::post('firstname'),
				'lastname' => Input::post('lastname'),
				'email' => Input::post('email'),
			)
		);
	}


}
