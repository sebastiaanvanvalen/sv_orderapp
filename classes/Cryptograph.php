<?php



class Cryptograph {
    private $key;

    public function __construct($key){
        $this->key = $key;
        if (empty($key)){
            throw new PDOException("key for encrypting could not be used");
            exit;
        }
    }

    public function decryptValue($value){
        $vars      = explode('|', $value);
        $value     = $vars[0];
        $nonce     = $vars[1];
        
        /**
         * TODO : error handling
         */

        return Sodium\crypto_secretbox_open(Sodium\hex2bin($value), Sodium\hex2bin($nonce), $this->key);
    }

    public function encryptValue($value){
        $nonce  = Sodium\randombytes_buf(Sodium\CRYPTO_SECRETBOX_NONCEBYTES);
        $vars   = $value;
        $pass   = Array();
        $pass[] = Sodium\bin2hex(Sodium\crypto_secretbox($vars, $nonce, $this->key));
        $pass[] = Sodium\bin2hex($nonce);
        $pass[] = 'end';
    
        $encrypted = implode('|', $pass);

        return $encrypted;
    }
}
?>