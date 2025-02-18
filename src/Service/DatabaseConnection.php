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

            // first check if the pslzme database tables exist. Create them only when not present
            $this->initTables();
  
        } catch(DatabaseException $dbe) {
            \System::log($dbe->getErrorMsg(),__METHOD__,TL_ERROR);
        } catch (Exception $e) {
            error_log($e->getMessage());
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

    private function initTables() {
        // create all tables
        $this->createPslzmeCustomerTable();
        $this->createEncryptionInfoTable();
        $this->createQueryLinkTable();
    }

    private function createPslzmeCustomerTable() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS pslzme_kunde (
            KundenID BIGINT AUTO_INCREMENT PRIMARY KEY,
            Name varchar(255)
        )";

        $result = $this->connection->query($sqlQuery);
        if ($result === true) {
            System::log("Table pslzme_kunde created successfully",__METHOD__,TL_GENERAL);
        } else {
            throw new DatabaseException("Unable to create table pslzme_kunde");
        }
    }

    private function createEncryptionInfoTable() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS encrypt_info (
            EncryptionID BIGINT AUTO_INCREMENT PRIMARY KEY,
            EncryptionKey varchar(255) NOT NULL,
            PslzmeKundenID BIGINT NOT NULL,

            CONSTRAINT fk_kunden_id FOREIGN KEY (PslzmeKundenID) REFERENCES pslzme_kunde(KundenID) ON DELETE CASCADE
        )";

        $result = $this->connection->query($sqlQuery);
        if ($result === true) {
            System::log("Table encrypt_info created successfully",__METHOD__,TL_GENERAL);
        } else {
            throw new DatabaseException("Unable to create table encrypt_info");
        }
    }

    private function createQueryLinkTable() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS query_link (
            QueryID INT AUTO_INCREMENT PRIMARY KEY,
            QueryString VARCHAR(255) NOT NULL,
            CreationTime BIGINT,
            AcceptionTime BIGINT,
            ChangedOn BIGINT,
            Accepted TINYINT(1) NOT NULL,
            Locked TINYINT(1) NOT NULL DEFAULT 0,
            PslzmeKundenID BIGINT NOT NULL,
            EncryptInfoID BIGINT NOT NULL,
        
            CONSTRAINT fk_kunden_id FOREIGN KEY (PslzmeKundenID) REFERENCES pslzme_kunde(KundenID),
            CONSTRAINT fk_encryption_id FOREIGN KEY (EncryptInfoID) REFERENCES encrypt_info(EncryptionID)
        )";
        
        $result = $this->connection->query($sqlQuery);
        if ($result === true) {
            System::log("Table query_link created successfully",__METHOD__,TL_GENERAL);
        } else {
            throw new DatabaseException("Unable to create table query_link");
        }
    }
}
?>