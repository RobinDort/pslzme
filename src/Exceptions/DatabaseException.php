<?php
use Exception;

class DatabaseException extends Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }


    public function getErrorMsg() {
        return "[DatabaseException] Error: " . $this->getMessage();
    }
}
?>