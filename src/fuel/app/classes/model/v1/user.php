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
	 * Validate input data.
	 *
	 * @return array Error data including error message list
	 */
	public static function validate_input() {
		try {
			// Create a new validation instance
			$val = \Validation::forge('user');
	
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
		}
	}
	
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
			//Write log
			Ultility_Log::log(Fuel::L_ERROR, $e, $method = "is_existed()");
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
		} catch (\Exception $e) {
			//Write log
			\Ultility_Log::log(\Fuel::L_ERROR, $e, $method = "create_acount()");
		}
	}

	/**
	 * Get user account info.
	 * 
	 * @param int $user_id User ID (system id)
	 * @return array User account info in array format
	 */
	public static function get_user_info($user_id) {
		try {
			// Prepare an insert statement
			$query = DB::query('SELECT * FROM user WHERE id = :user_id AND status = 1', DB::SELECT);
		
			// Bind the variable
			$query->bind('user_id', $user_id);
		
			// Execute the query and return a new Database_MySQLi_Result
			$result = $query->execute();
				
			// Return check result
			return $result[0];
				
		} catch (Exception $e) {
			//Write log
			Ultility_Log::log(Fuel::L_ERROR, $e, $method = "get_user_info()");
		}	
	}

	/**
	 * Remove user account info.
	 * 
	 * @param int $user_id User ID (system id)
	 * @return boolean True id remove success. Otherwise, False.
	 */
	public static function remove_account($user_id) {
		try {
			// Prepare an insert statement
			$query = DB::query('DELETE FROM user WHERE id = :user_id', DB::DELETE);
	
			// Bind the variable
			$query->bind('user_id', $user_id);
	
			// Execute the query and return a new Database_MySQLi_Result
			$result = $query->execute();
				
			// Return check result
			return ($result == 1) ? true : false;
				
		} catch (Exception $e) {
			//Write log
			Ultility_Log::log(Fuel::L_ERROR, $e, $method = "remove_account()");
		}
	}
	
}
