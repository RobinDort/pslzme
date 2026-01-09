<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;
use Psr\Log\LoggerInterface;
use Contao\System;

class DatabaseManager {

    private $dbc;
    private $logger;

    private const TABLE_REFERENCE = 
    [
        "pslzme_kunde" => "createPslzmeCustomerTable",
        "encrypt_info"  => "createEncryptionInfoTable",
        "query_link"    => "createQueryLinkTable"
    ];

    public function __construct(DatabaseConnection $dbc, LoggerInterface $logger) {
        $this->dbc = $dbc;
        $this->logger = $logger;
    }


    public function initTables() {

        try {
            // first check if the pslzme database tables exist. Create them only when not present
            // begin transaction to make sure all tables get created.
            $this->dbc->getConnection()->begin_transaction();

            $this->createPslzmeCustomerTable();
            $this->createEncryptionInfoTable();
            $this->createQueryLinkTable();

            $this->dbc->getConnection()->commit();
        } catch(DatabaseException $dbe) {
            $this->$dbc->getConnection()->rollback();
            $this->$dbc->getConnection()->closeConnection();
            error_log($dbe->getErrorMsg());

        } catch (Exception $e) {
            $this->$dbc->getConnection()->rollback();
            $this->dbc->getConnection()->closeConnection();
            error_log($e->getMessage());
        }

    }

    private function createPslzmeCustomerTable() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS pslzme_kunde (
            KundenID BIGINT AUTO_INCREMENT PRIMARY KEY,
            Name varchar(255) NOT NULL
        )";

        $result = $this->dbc->getConnection()->query($sqlQuery);
        if ($result === true) {
            $this->logger->info("Table pslzme_kunde created successfully");
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

        $result = $this->dbc->getConnection()->query($sqlQuery);
        if ($result === true) {
            $this->logger->info("Table encrypt_info created successfully");
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
        
            CONSTRAINT fk_ql_kunden_id FOREIGN KEY (PslzmeKundenID) REFERENCES pslzme_kunde(KundenID),
            CONSTRAINT fk_ql_encryption_id FOREIGN KEY (EncryptInfoID) REFERENCES encrypt_info(EncryptionID)
        )";
        
        $result = $this->dbc->getConnection()->query($sqlQuery);
        if ($result === true) {
            $this->logger->info("Table query_link created successfully");
        } else {
            throw new DatabaseException("Unable to create table query_link");
        }
    }
}


?>