<?php

class TokenHandler {

    public function chooseType($tokenType, $csrfKey){

        try{
            switch ($tokenType){
                case "clientToken":
                    include("../classes/ClientToken.php");
                    $clientToken = new ClientToken();
                    $clientToken->check($csrfKey);
                    break;
                case "BinQB98":
                    include("../classes/AdminToken.php");
                    $AdminToken = new AdminToken();
                    $AdminToken->check($csrfKey);
                    break;
                case "clientCancelToken":
                    include("../classes/ClientCancelToken.php");
                    $clientCancelToken = new ClientCancelToken();
                    $clientCancelToken->check($csrfKey);
                    break;
                default:
                    throw new PDOException("could not validate token");
            } 
        } catch (PDOException $e) {
            echo "204" . "\n" . $e->getMessage() . "\n\n";
        }
    }
}
