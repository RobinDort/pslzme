<?php
namespace RobinDort\PslzmeLinks\Exceptions;

use Exception;

class InvalidDecryptionException extends Exception {

    public function __constuct($message, $code = 0, Exception $previous = null) {
        parent::__constuct($message, $code, $previous);
    }

    public function getErrorMsg() {
        return "[InvalidDecryptionException] Error: " . $this->getMessage();
    }

}

?>