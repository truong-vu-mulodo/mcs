<?php
use Fuel\Core\DB;
use \Model\V1\User;
/**
 * The test class for User model version v1.
 *
 *
 * @group User
 * @package  app
 * @extends  TestCase
 * @author Vu Truong
 * @since 2014/11/04
 */
class Test_Model_V1_User extends TestCase {
	
	protected static $user;
	
	/**
	 * Init test resource (FUNCTION LEVEL).
	 */
	protected function setUp() {
	}
	
	/**
	 * Cleanup test resource (FUNCTION LEVEL).
	 */
	protected function tearDown() {
	}

	/**
	 * Init test resource (CLASS LEVEL).
	 */
	public static function setUpBeforeClass() {
		self::$user = new User();
	}

	/**
	 * Cleanup test resource (CLASS LEVEL).
	 */
	public static function tearDownAfterClass() {
		global $user;
		unset($user);
	}

	/**
	 * Define test data set
	 *
	 * @return array Test data
	 */
	public function init_data() {
		// Read from external file
		// 		return new CsvFileIterator('data.csv');
	
		// Or create directly
		$test_data = array();
	
		for ($i = 0; $i < 1; $i++) {
			$test_data[][] = array(
					'username' => 'vutm',
					'password' => md5('mypass'),
					'firstname' => 'Vu',
					'lastname' => 'Truong',
					'email' => 'truong.vu@mulodo.com'
			);
		}
		return $test_data;
	}

	/**
	 * Create user account.
	 * This will insert new record into "user" table from provided information.
	 * 
	 * Intended to use data provider but this function's depending function can not inject any return value.
	 *
	 * @test
	 */
	public function create_acount_ok() {
		// Test data
		$user_info = array(
						'username' => 'vutm',
						'password' => md5('mypass'),
						'firstname' => 'Vu',
						'lastname' => 'Truong',
						'email' => 'truong.vu@mulodo.com'
					);
		
		// Create account
		$user_id = self::$user->create_acount($user_info);
		// Create success
		$this->assertGreaterThan(0, $user_id);
		// Get user account has just created
		$created_user = self::$user->get_user_info($user_id);
		// Compare each value
		$this->assertEquals('vutm', $created_user['username']);
		$this->assertEquals(md5('mypass'), $created_user['password']);
		$this->assertEquals('Vu', $created_user['firstname']);
		$this->assertEquals('Truong', $created_user['lastname']);
		$this->assertEquals('truong.vu@mulodo.com', $created_user['email']);

		// Add insert id
		$user_info['user_id'] = $user_id;

		return $user_info;
	}
	
	/**
	 * Check if a username existed.
	 * Case: OK
	 *
	 * @test
	 * @depends create_acount_ok
	 */
	public function is_existed_ok($user_info) {

		// Check user account existed
		$user_existed = self::$user->is_existed($user_info['username']);

		// Compare result
		$this->assertTrue($user_existed);
	}

	/**
	 * Check if a username existed.
	 * Case: FAILURE
	 * @test
	 */
	public function is_existed_failure($username = 'not_existed_username') {
		// Check user account existed
		$user_existed = self::$user->is_existed($username);
	
		// Compare result
		$this->assertFalse($user_existed);
	}
	
	/**
	 * Get user info.
	 *
	 * @test
	 * @depends create_acount_ok
	 */
	public function get_user_info_ok($user_info) {
		// Get user account
		$user_info = self::$user->get_user_info($user_info['user_id']);

		// Compare each value
		$this->assertNotNull($user_info['id']);
		$this->assertNotNull($user_info['username']);
		$this->assertNotNull($user_info['password']);
		$this->assertNotNull($user_info['firstname']);
		$this->assertNotNull($user_info['lastname']);
		$this->assertNotNull($user_info['email']);
	}

	/**
	 * Get user info failure.
	 *
	 * @test
	 */
	public function get_user_info_failure($user_id = 1001) {
		// Create account
		$user_info = self::$user->get_user_info($user_id);
		// Compare count
		$this->assertEquals(0, count($user_info));
	}

	/**
	 * Remove user account.
	 *
	 * @test
	 * @depends create_acount_ok
	 */
	public function remove_acount_ok($user_info) {	
		// Remove account
		$result = self::$user->remove_account($user_info['user_id']);

		$this->assertTrue($result);
	}
}
