<?php
namespace RobinDort\PslzmeLinks\Service;

use mysqli;

class DatabaseConnection {
    private $connection;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;


        try {
            // create connection
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            // check if connection was established
            if($this->connection->connect_error) {
                throw new \Exception("Connection failed: " . $this->connection->connect_error);
            } 
        } catch (Exception $e) {
            error_log($e->getMessage());
            // Rethrow the exception so the caller knows the connection failed
            throw $e;
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
}
?>