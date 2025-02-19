<?php
namespace RobinDort\PslzmeLinks\Service;

use mysqli;
use Contao\System;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;

class DatabaseConnection {
    private $connection;
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;


        try {
            // create connection to database
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            // check if connection was established
            if($this->connection->connect_error) {
                throw new \Exception("Connection to database failed: " . $this->connection->connect_error);
            } 
              
        } catch (Exception $e) {
            $this->connection->rollback();
            $this->closeConnection();
            error_log($e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection !== null && $this->connection->ping()) {
            $this->connection->close();
        }
    }
}
?>