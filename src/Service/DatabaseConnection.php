<?php
namespace RobinDort\PslzmeLinks\Service;

use mysqli;
use Contao\System;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Service\DatabaseManager;
use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

use Exception;

class DatabaseConnection {
    private $connection;
    private $dbStmtExecutor;
   
    public function __construct(DatabasePslzmeConfigStmtExecutor $dbStmtExecutor) {
        try {
            // Get the database data
            $this->dbStmtExecutor = $dbStmtExecutor;
            $dbData = $this->dbStmtExecutor->selectCurrentDatabaseConfigurationData();

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

            $password = $this->decryptPassword($encryptedPW, $timestamp);

            $connectionParams = [
                'dbname'   => $dbname,
                'user'     => $username,
                'password' => $decryptedPW,
                'host'     => $servername,
                'driver'   => 'pdo_mysql',
                'charset'  => 'utf8mb4',
            ];
     
            // create connection to database
            $this->connection = DriverManager::getConnection($connectionParams);
            //$this->connection = new mysqli($servername, $username, $decryptedPW, $dbname);

            $this->connection->connect();

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
        if (!$this->connection) {
            throw new DatabaseException("Database connection is not initialized.");
        }
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection && $this->connection->isConnected()) {
            $this->connection->close();
        }
    }
    
    private function decryptPassword($encryptedPassword, $timestamp) {
        $secretKey = hash('sha256', $timestamp, true); // Recreate key from timestamp
        $data = base64_decode($encryptedPassword);
        
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);

        $decryptedPW = openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
        
        return $decryptedPW;
    }
}
?>