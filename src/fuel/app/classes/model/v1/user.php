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
	 * Check if an account was existed or not, based on username.
	 *
	 * @access  public
	 * @return  boolean True if account existed. False if not existed.
	 */
	public static function is_existed($username) {
		try {
			// Prepare an insert statement
			$query = DB::query('SELECT * FROM user WHERE username = :username AND status = 1', DB::SELECT);

			// Bind the variable
			$query->bind('username', $username);
				
			// Execute the query and return a new Database_MySQLi_Result
			$result = $query->execute();
			
			// Return check result
			return (DB::count_last_query() > 0) ? true : false;
			
		} catch (Exception $e) {
			// Write log here
		}
	}
	
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
