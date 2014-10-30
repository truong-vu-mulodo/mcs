<?php
namespace Model\V1;

use Fuel\Core\DB;
use Fuel\Core\Model;
/**
 * The User Model version v1.
 *
 * Contains all business logic for Users API endpoints.
 *
 * @package  app
 * @extends  Model
 * @author Vu Truong
 * @since 2014/10/30
 */
class User extends Model {

	/**
	 * Create user account.
	 * This will insert new record into "user" table from provided information.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public static function create_acount($user_info) {
		try {
			// Prepare an insert statement
			$query = DB::insert('user');
			
			// Set the columns
			$query->columns(array(
					'username',
					'password',
					'firstname',
					'lastname',
					'email',
					'create_dt',
					'update_dt'
			));
			
			// Set the values
			$query->values(array(
					$user_info['username'],
					$user_info['password'],
					$user_info['firstname'],
					$user_info['lastname'],
					$user_info['email'],
					time(),
					time()
			));
			
			// Execute the query and return a new Database_MySQLi_Result
			$result = $query->execute();

			// Return new record's id
			return $result[0];
		} catch (Exception $e) {
			// Write log here
		}
	}


}
