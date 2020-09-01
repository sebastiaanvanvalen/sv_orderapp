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
        
        return Sodium\crypto_secretbox_open(Sodium\hex2bin($value), Sodium\hex2bin($nonce), $this->key);
    }

    public function encryptValue($value){
        // deleted
    
        $encrypted = implode('|', $pass);

        return $encrypted;
    }
}
?>
