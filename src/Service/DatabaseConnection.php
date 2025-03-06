<?php
namespace RobinDort\PslzmeLinks\Service;

use mysqli;
use Contao\System;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Service\DatabaseManager;
use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

use Exception;

class DatabaseConnection {
    private $connection;
    // private $servername;
    // private $username;
    // private $password;
    // private $dbname;

    // public function __construct($servername, $username, $password, $dbname) {
    //     $this->servername = $servername;
    //     $this->username = $username;
    //     $this->password = $password;
    //     $this->dbname = $dbname;


    //     try {
    //         // create connection to database
    //         $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    //         // check if connection was established
    //         if($this->connection->connect_error) {
    //             throw new Exception("Connection to database failed: " . $this->connection->connect_error);
    //         } 

    //     } catch (Exception $e) {
    //         $this->connection->rollback();
    //         $this->closeConnection();
    //         error_log($e->getMessage());
    //     }
    // }


    public function __construct() {
        try {
            // Get the database data
            $dbStmtExecutor = new DatabasePslzmeConfigStmtExecutor();
            $dbData = $dbStmtExecutor->selectCurrentDatabaseConfigurationData();

            if(empty($dbData["databaseUser"]) || empty($dbData["databasePassword"]) || empty($dbData["databaseTimestamp"]) || empty($dbData["databaseName"])) {
                throw new DatabaseException("No correct pslzme database configuration specified.");
            } 

            $servername = "localhost";
            $username =  $dbData["databaseUser"];
            $encryptedPW = $dbData["databasePassword"];
            $timestamp = $dbData["databaseTimestamp"];
            $dbname =  $dbData["databaseName"];

            // decrypt the password
            $decryptedPW = $this->decryptPassword($encryptedPW, $timestamp);
            error_log("decrypted PW: " .$decryptedPW);
            \System::log("decrypted PW: " . $decryptedPW, __METHOD__, TL_ERROR);
     
            // create connection to database
            $this->connection = new mysqli($servername, $username, $decryptedPW, $dbname);

            // check if connection was established
            if($this->connection->connect_error) {
                throw new DatabaseException("Connection to database failed: " . $this->connection->connect_error);
            } 

        } catch(InvalidDataException $ide) {
            error_log($ide->getErrorMsg());
            $this->closeConnection();
        } catch(DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
            $this->closeConnection();
        } catch(Exception $e) {
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
    
    private function decryptPassword($encryptedPassword, $timestamp) {
        $secretKey = hash('sha256', $timestamp); // Recreate key from timestamp
        $data = base64_decode($encryptedPassword);
        
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        
        return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
    }
}
?>