<?php
namespace RobinDort\PslzmeLinks\Exceptions;

use Exception;

class InvalidDataException extends Exception {

    public function __constuct($message, $code = 0, Exception $previous = null) {
        parent::__constuct($message, $code, $previous);
    }

    public function getErrorMsg() {
        return "[InvalidDataException] Error: " . $this->getMessage();
    }

}

?>