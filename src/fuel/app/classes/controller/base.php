<?php
// namespace Controller;

use Fuel\Core\Controller_Rest;
// use \Model\V1\User;
use \Ultility\Error;
/**
 * The Base User Controller for all versions.
 * All common methods for controllers should be declared here.
 *
 * @package  app
 * @extends  Controller_Rest
 * @author Vu Truong
 * @since 2014/10/31
 */
class Controller_Base extends Controller_Rest {

	/**
	 * Get system error's error content. 
	 * This will be converted to JSON in response.
	 *
	 * @return array Error content for response
	 */
	protected function get_system_error_response() {
		// Return error info by array format
		return array(
				'meta' => array(
						'code' => _SYSTEM_ERROR_CODE_,
						'description' => "System error.",
						'messages' => array('message' => _SYSTEM_ERROR_MSG_)
				),
				'data' => null
		);
	}

}
