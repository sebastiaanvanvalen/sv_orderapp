<?php


class AdminToken{
    private $key;

    public function create(){
        $_SESSION['PASS'] = 'Buf6klDCo0Fjktr32Wdxcik0dwfj976'; 
        $timestamp   = time() + (7 * 24 * 60);
        $passphrase  = $_SESSION['PASS'];
        $passphrase .= ''; 
        $passphrase .= ;
        $secret      = '';
        $algo        = '';

        return bin2hex(hash_hmac($algo, $passphrase, $secret, true)) . '|' .  $timestamp;
    }

    public function check($key){
        $parts = explode('|', substr($key, 7));
        $passphrase  = $_SESSION['PASS'];
        $passphrase .= '';
        $passphrase .= [1];
        $secret      = '';
        $algo        = '';

        try{
            if (!hash_equals(hex2bin($parts[0]), hash_hmac($algo, $passphrase, $secret, true))) {
                throw new PDOException;
                // this must mean soms kind of break in (or error)?
                exit;
            }

        } catch (PDOException $e){
            // maybe not show errors to client?
            echo json_encode($e->getMessage);
        }
    }
}
