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
     * 
     * @param unknown $token
     * @return NULL|unknown
     */
    public static function parse_token($token) {
    	if (!$token) {
    		return null;
    	}
		// Create new cipher object
    	$cipher = new Ultility_Cipher(_ENCRYPT_SECRETE_KEY_);
    	// Decrypt the token
    	$decrypt_token = $cipher->decrypt($token);
    	// Parse the token to get data
    	$token_items = explode('@', $decrypt_token);
    	
// echo( date('l dS \o\f F Y h:i:s A', $token_items[3]));
    	
    	// Return the items array
    	return $token_items;
    }
}
?>