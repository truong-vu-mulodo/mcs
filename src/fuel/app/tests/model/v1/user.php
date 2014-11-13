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
	
	private $user;
	
	private $created_user_id = null;
	
	/**
	 * Init test resource.
	 */
	protected function setUp() {
		$this->user = new User();
	}
	
	/**
	 * Cleanup test resource.
	 */
	protected function tearDown() {
		// Remove test data
		$this->user->remove_account($this->created_user_id);
		unset($this->user);
	}

	/**
	 * Check if a username existed.
	 * Case: OK
	 *
	 * @test
	 */
	public function is_existed_ok($username = 'vutm') {
		// Check user account existed
		$user_existed = $this->user->is_existed($username);
		
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
		$user_existed = $this->user->is_existed($username);
	
		// Compare result
		$this->assertFalse($user_existed);
	}
	
	/**
	 * Get user info.
	 *
	 * @test
	 */
	public function get_user_info_ok($user_id = 2) {
		// Get user account
		$user_info = $this->user->get_user_info($user_id);

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
		$user_info = $this->user->get_user_info($user_id);
		// Compare count
		$this->assertEquals(0, count($user_info));
	}
	
	/**
	 * Create user account.
	 * This will insert new record into "user" table from provided information.
	 * 
	 * @test
	 * @dataProvider init_data
	 */
	public function create_acount_ok($user_info) {
		// Create account
		$user_id = $this->user->create_acount($user_info);
		// Create success
		$this->assertGreaterThan(0, $user_id);
		// Get user account has just created
		$created_user = $this->user->get_user_info($user_id);
		// Compare each value
		$this->assertEquals('vutm', $created_user['username']);
		$this->assertEquals(md5('mypass'), $created_user['password']);
		$this->assertEquals('Vu', $created_user['firstname']);
		$this->assertEquals('Truong', $created_user['lastname']);
		$this->assertEquals('truong.vu@mulodo.com', $created_user['email']);
		// Reserve the id for cleanup resource
		$this->created_user_id = $user_id;
	}

	/**
	 * Define test data set
	 * 
	 * @return array Test data
	 */
	public function init_data() {
// 		return new CsvFileIterator('data.csv');
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
	
	
	
}
