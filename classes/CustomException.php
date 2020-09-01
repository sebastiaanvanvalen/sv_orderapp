<?php

class CustomException extends Exception {
    
    public function __construct($customMessage){
        /**
         * @param $customMessage
         * 
         * Make your own error message.
         */
        $this->customMessage = $customMessage;
    }

    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
        ." : \n".$this->getMessage() . "\n" . $customMessage;

        return $errorMsg;
    }
}
