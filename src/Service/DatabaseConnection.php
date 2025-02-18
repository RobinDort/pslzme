<?php
namespace RobinDort\PslzmeLinks\Service;

use mysqli;

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
            // first check if the pslzme database exists
            $dbExists = databaseExists();

            if (!$dbExists) {
                // The database does not exist and must therefore be created first
                createPslzmeDatabase();
            } else {
                // The database exists and the connection can be established
                // create connection
                $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

                // check if connection was established
                if($this->connection->connect_error) {
                    throw new \Exception("Connection to database failed: " . $this->connection->connect_error);
                } 
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

    private function databaseExists() {

        // establish a connection to the mysql server. NOT to the database in order to check for the database existence
        $conn = new mysqli($this->servername, $this->username, $this->password);

        // check if connection was established
        if($conn->connect_error) {
            throw new \Exception("Connection to mysql server failed: " . $conn->connect_error);
        } 

        // connection established
        // select the database by its name
        $sqlQuery = "SHOW DATABASES LIKE '" . $this->dbname . "'";
        $result = $conn->query($sqlQuery);

        // Close the connection after the query
        $conn->close();

        if ($result->num_rows === 0) {
            // Database does not exist
            return false;
        } else {
            // Database already exists
            return true;
        }
    }


    private function createPslzmeDatabase() {
        // establish a connection to the mysql server. NOT to the database in order to create it
        $conn = new mysqli($this->servername, $this->username, $this->password);

        // check if connection was established
        if($conn->connect_error) {
            throw new \Exception("Connection to mysql server failed: " . $conn->connect_error);
        }

        $sqlQuery = "CREATE DATABASE " . $this->dbname;
        $result = $conn->query($sqlQuery);

        $conn->close();
        
        if ($result) {
            \System::Log("Database created successfully.", __METHOD__,TL_GENERAL);
        } else {
            throw new Exception("Error while trying to create pslzme_customer database");
        }

    }
}
?>