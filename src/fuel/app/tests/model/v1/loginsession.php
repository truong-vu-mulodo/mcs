<?php
use Fuel\Core\DB;
use \Model\V1\LoginSession;
/**
 * The test class for LoginSession model version v1.
 *
 *
 * @group User
 * @package  app
 * @extends  TestCase
 * @author Vu Truong
 * @since 2014/11/01
 */
class Test_Model_V1_LoginSession extends TestCase {
	
	const _EXISTED_USER_ID_ = 1;
	const _SAMPLE_TOKEN_ = 'DBkOzjhersKvUnnXmBRLj/KRm2kkLj8/5O2nOwHSaRkjNQ6rb7GA8wJNww94U4mCoWhkhoLZoOlpaAWR4nzIJw==';
	
	protected static $login_session;
	
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
		self::$login_session = new LoginSession();
	}

	/**
	 * Cleanup test resource (CLASS LEVEL).
	 */
	public static function tearDownAfterClass() {
		global $login_session;
		unset($login_session);
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
					'user_id' => self::_EXISTED_USER_ID_,
					'access_token' => self::_SAMPLE_TOKEN_,
					'last_login_dt' => time(),
					'create_dt' => time(),
					'update_dt' => time()
			);
		}
		return $test_data;
	}
	
	/**
	 * Create user login session.
	 * This will insert new record into "login_sesion" table from provided information.
	 * 
	 * @test
	 */
	public function create_login_session_ok() {
		$session_info = array(
				'user_id' => self::_EXISTED_USER_ID_,
				'access_token' => self::_SAMPLE_TOKEN_,
				'last_login_dt' => time(),
				'create_dt' => time(),
				'update_dt' => time()
		);
		
		// Create account
		$session_id = self::$login_session->create_login_session($session_info);
		// Create success
		$this->assertGreaterThan(0, $session_id);

		return $session_id;
	}

	/**
	 * Get user login session info.
	 *
	 * @test
	 * @depends create_login_session_ok
	 */
	public function get_access_token_ok($session_id) {
		// Get login session
		$access_token = self::$login_session->get_access_token($session_id);
		// Create success
		$this->assertEquals(self::_SAMPLE_TOKEN_, $access_token);

		return $access_token;
	}
}
