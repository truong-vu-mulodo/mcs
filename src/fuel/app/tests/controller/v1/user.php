<?php
use Fuel\Core\DB;
// use \Controller\V1\User;
/**
 * The test class for User controller version v1.
 *
 *
 * @group User
 * @package  app
 * @extends  TestCase
 * @author Vu Truong
 * @since 2014/11/07
 */
class Test_Controller_V1_User extends TestCase {
	
	/**
	 * Init test resource.
	 */
	protected function setUp() {
	}
	
	/**
	 * Cleanup test resource.
	 */
	protected function tearDown() {
		// Remove test data
	}
	
	/**
	 * Post (create) user account.
	 * 
	 * @test
	 * @dataProvider init_data
	 */
	public function post_create_validate_failure($post_params) {
		// create a Request_Curl object
		$curl = Request::forge('http://localhost/mcs/public/v1/users.json', 'curl');
		// this is going to be an HTTP POST
		$curl->set_method('POST');
		// set some parameters
		$curl->set_params($post_params);		
		// execute the request
		$curl->execute();
		// Get response object
		$result = $curl->response();
		// Get response body
		$resp_body = json_decode($result->body(), true);
		// Compare result		
		$this->assertEquals(1001, $resp_body['meta']['code']);
	}

	/**
	 * Define test data set
	 * 
	 * @return array Test data
	 */
	public function init_data() {
		$test_data = array();
		// Null username
		$test_data[][] = array(
				'username' => '',
				'password' => 'pass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);
		// Lenght < 4 username
		$test_data[][] = array(
				'username' => 'vut',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Lenght > 40 username
		$test_data[][] = array(
				'username' => '1234567890123456789012345678901234567890_41',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Not "alphanumeric" username
		$test_data[][] = array(
				'username' => 'vutm*&',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Null password
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => '',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Lenght > 40 password
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => '1234567890123456789012345678901234567890_41',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Not "alphanumeric" password
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass*&',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Null firstname
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => '',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);
		
		// Lenght > 40 firstname
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => '1234567890123456789012345678901234567890_41',
				'lastname' => 'Truong',
				'email' => 'truong.vu@mulodo.com'
		);

		// Null lastname
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => '',
				'email' => 'truong.vu@mulodo.com'
		);
		
		// Lenght > 40 lastname
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => '1234567890123456789012345678901234567890_41',
				'email' => 'truong.vu@mulodo.com'
		);

		// Null email
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => ''
		);
		
		// Lenght > 255 email
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890_300'
		);

		// Invalid email
		$test_data[][] = array(
				'username' => 'vutm',
				'password' => 'mypass',
				'firstname' => 'Vu',
				'lastname' => 'Truong',
				'email' => 'truong.vumulodo.com'
		);
		
		return $test_data;
	}
}
