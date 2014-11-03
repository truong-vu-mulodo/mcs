<?php
/**
 * Ultility functions for token ecrypt/decrypt.
 *
 * @author Vu Truong
 * @since 2014/11/03
 */
class Ultility_Cipher {
	
	private $secure_key, $iv;

    /**
     * Constructor.
     */
    public function __construct($pass) {
    	$this->secure_key = hash('sha256', $pass, true);
    	$this->iv = mcrypt_create_iv(32);
    }
    
    /**
     * Encrypt data.
     * 
     * @param String $input Data need to be encrypted
     */
    public function encrypt($input) {
    	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->secure_key, $input, MCRYPT_MODE_ECB, $this->iv));
    }
    
    /**
     * Decrypt data.
     * 
     * @param String $input  Data need to be decrypted
     */
    public function decrypt($input) {
    	return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->secure_key, base64_decode($input), MCRYPT_MODE_ECB, $this->iv);
    }

}
?>