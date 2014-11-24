<?php
/**
 * Defines all constants.
 * 
 * This file should be included in bootstrap.php file.
 * 
 * @author Vu Truong
 * @since 2014/10/30
 * 
 */

// ### Common Constants ###
// Secrete key
define('_ENCRYPT_SECRETE_KEY_', 'mulodo_mcs_key');

// ### Normal Codes ###
define('_API_CALL_SUCCESS_CODE_', '200');

// ### Error Codes ###
// Input validation
define('_VALIDATE_FAILED_CODE_', '1001');

// Common errors
define('_SYSTEM_ERROR_TYPE_', 'SYSTEM_ERROR');
define('_DATABASE_ERROR_TYPE_', 'DATABASE_ERROR');

// ### Error Messages ###
// Validation error messages
define('_DATA_REQUIRED_MSG_', ':label is required.');
define('_DATA_INVALID_MSG_', ':label is invalid.');

// Normal messages
define('_USER_CREATED_SUCCESS_MSG_', 'User account created successfully!');

// Error codes & messages
define('_SYSTEM_ERROR_CODE_', '9001');
define('_SYSTEM_ERROR_MSG_', 'System error occured. Please contact administrator.');

define('_DATABASE_ERROR_MSG_', 'Database error occured. Please contact administrator.');
define('_DATABASE_ERROR_CODE_', '9002');

define('_USERNAME_EXISTED_CODE_', '2001');
define('_ACCOUNT_EXISTED_MSG_', 'Account existed.');