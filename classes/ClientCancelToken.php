<?php

class ClientCancelToken{
    private $key;

    public function create(){
        $_SESSION['PASS'] = 'cR9KmG33@x0h4szae3fbnkiu790='; 
        $timestamp   = time() + (7 * 24 * 60);
        $passphrase  = $_SESSION['PASS'];
        $passphrase .= 'hItCHhIckErs83GuiDe092@tOtHe783GaLa87Xy'; 
        $passphrase .= $timestamp;
        $secret      = 'Hu999972JulianaSquare%huple';
        $algo        = 'sha512';

        return bin2hex(hash_hmac($algo, $passphrase, $secret, true)) . '|' .  $timestamp;
    }

    public function check($key){
        $token = $key;
        $parts = explode('|', substr($key, 7));
        $passphrase  = $_SESSION['PASS'];
        $passphrase .= 'hItCHhIckErs83GuiDe092@tOtHe783GaLa87Xy';
        $passphrase .= $parts[1];
        $secret      = 'Hu999972JulianaSquare%huple';
        $algo        = 'sha512';

        try{
            if (!hash_equals(hex2bin($parts[0]), hash_hmac($algo, $passphrase, $secret, true))) {
                throw new PDOException();
                // this must mean soms kind of break in (or error)?
                // exit;
            }

        } catch (PDOException $e){
            // maybe not show errors to client?
            echo json_encode($e);
        }
    }

}


