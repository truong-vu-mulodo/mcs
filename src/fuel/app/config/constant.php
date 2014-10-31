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

// ### Error Codes ###
// Input validation
define('_VALIDATE_FAILED_CODE_', '1001');

// Data exist
define('_USERNAME_EXISTED_CODE_', '2001');

// Common errors
define('_SYSTEM_ERROR_CODE_', '9001');

// ### Error Messages ###
// Validation error messages
define('_DATA_REQUIRED_MSG_', ':label is required.');
define('_DATA_INVALID_MSG_', ':label is invalid.');

// Common error messages
define('_SYSTEM_ERROR_MSG_', 'System error occured. Please contact administrator.');