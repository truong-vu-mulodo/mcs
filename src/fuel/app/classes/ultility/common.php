<?php
/**
 * Ultility functions for common functionality.
 *
 * @author Vu Truong
 * @since 2014/11/04
 */
class Ultility_Common {

    /**
     * Constructor.
     */
    public function __construct() {
    }

    /**
     * Decrypt and parse encrypted token to items in array format.
     * 
     * @param String $encrypt_token Encrypted token to be parsed
     * @return NULL|Array Parsed items in array format
     */
    public static function parse_token($encrypt_token) {
    	if (!$encrypt_token) {
    		return null;
    	}
		// Create new cipher object
    	$cipher = new Ultility_Cipher(_ENCRYPT_SECRETE_KEY_);
    	// Decrypt the token
    	$decrypt_token = $cipher->decrypt($encrypt_token);
    	// Parse the token to get data
    	$token_items = explode('@', $decrypt_token);
    	
// echo( date('l dS \o\f F Y h:i:s A', $token_items[3]));
    	
    	// Return the items array
    	return $token_items;
    }
}
?>