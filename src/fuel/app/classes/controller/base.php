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
	protected function get_error_response($error_type = _SYSTEM_ERROR_TYPE_) {
		// Default info
		$error_code = _SYSTEM_ERROR_CODE_;
		$error_msg = _SYSTEM_ERROR_MSG_;
		
		switch ($error_type) {
			// System error
			case _SYSTEM_ERROR_TYPE_: {
				$error_code = _SYSTEM_ERROR_CODE_;
				$error_msg = _SYSTEM_ERROR_MSG_;
				break;
			}
			// Database error
			case _DATABASE_ERROR_TYPE_: {
				$error_code = _DATABASE_ERROR_CODE_;
				$error_msg = _DATABASE_ERROR_MSG_;
				break;
			}

			default;
		}
		
		// Return error info by array format
		return array(
				'meta' => array(
						'code' => $error_code,
						'description' => "System error.",
						'messages' => array('message' => $error_msg)
				),
				'data' => null
		);
	}

}
