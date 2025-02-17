<?php
namespace RobinDort\PslzmeLinks\Exceptions;

use Exception;

class InvalidFileException extends Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }


    public function getErrorMsg() {
        return "[InvalidFileException] Error: " . $this->getMessage();
    }
}
?>