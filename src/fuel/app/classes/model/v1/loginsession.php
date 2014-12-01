<?php
namespace Model\V1;

use Fuel\Core\DB;
use Fuel\Core\Model;
/**
 * The Login Session Model version v1.
 *
 * @package  app
 * @extends  Model
 * @author Vu Truong
 * @since 2014/11/03
 */
class LoginSession extends Model {
	
	/**
	 * Create login session data.
	 * This will insert new record into "login_session" table from provided information.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public static function create_login_session($session_data) {
		try {
			// Prepare an insert statement
			$query = DB::insert('login_session');
			
			// Set the columns
			$query->columns(array(
					'user_id',
					'access_token',
					'last_login_dt',
					'create_dt',
					'update_dt'
			));
			
			// Set the values
			$query->values(array(
					$session_data['user_id'],
					$session_data['access_token'],
					time(),
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

	/**
	 * Get access token from a session id.
	 * 
	 * @param int $session_id Login session id.
	 * @return string Access token.
	 */
	public static function get_access_token($session_id) {
		try {
			// Prepare an insert statement
			$query = DB::query('SELECT access_token FROM login_session WHERE id = :session_id', DB::SELECT);
	
			// Bind the variable
			$query->bind('session_id', $session_id);
	
			// Execute the query and return a new Database_MySQLi_Result
			$result = $query->execute();
	
			// Return result
			return $result[0]['access_token'];
				
		} catch (Exception $e) {
			// Write log here
		}
	}
}
