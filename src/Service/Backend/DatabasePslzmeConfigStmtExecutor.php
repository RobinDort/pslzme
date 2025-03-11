<?php
namespace RobinDort\PslzmeLinks\Service\Backend;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtPreparer;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;

use Contao\System;
//use Contao\Database;
use Doctrine\DBAL\Connection;


class DatabasePslzmeConfigStmtExecutor {
    //private $connection;
    private $dbPslzmeConfigStmtPreparer;

    public function __construct(private readonly Connection $connection) {
        //$this->connection = $connection;
        //$this->connection = Database::getInstance();
        $this->dbPslzmeConfigStmtPreparer = new DatabasePslzmeConfigStmtPreparer($this->connection);
    }

    public function initDatabaseConfigurationData($databaseName, $databaseUser, $databasePW, $timestamp) {
         // check if database options are already saved
         $selectResult = $this->selectDatabaseConfiguration();

         if ($selectResult["numRows"] > 0) {
            // database data has been found. Update it.
            $updateResult = $this->updateDatabaseConfiguration($databaseName, $databaseUser, $databasePW, $timestamp);
            return $updateResult;
         } else {
            // no database data found. Insert the new data
            // save the database data into the pslzme config table
            $insertResult = $this->insertDatabaseConfiguration($databaseName, $databaseUser, $databasePW, $timestamp);
            return $insertResult;
         }
    }


    public function saveInternalPagesData($internalPages) {
        // check if the database data has been saved before.
        $selectResult = $this->selectDatabaseConfiguration();

        if ($selectResult["numRows"] > 0) {
            // database data already saved -> update the pages.
            $updateResult = $this->updateInternalPagesData($internalPages);
            return $updateResult;
        } else {
            throw new DatabaseException("Unable to update internal pages. Database data must be configured first.");
        }
    }

    public function selectCurrentDatabaseConfigurationData() {
            $selectResult = $this->selectDatabaseConfiguration();
            $rows = $selectResult["rows"];
            if (!empty($rows)) {
                // only one data configuration entry exists, so only the first row contains the needed data.
                $databaseName = $rows[0]["pslzme_db_name"];
                $databaseUser = $rows[0]["pslzme_db_user"];
                $databasePassword = $rows[0]["pslzme_db_pw"];
                $databaseIPR = $rows[0]["pslzme_ipr"];
                $databaseTimestamp = $rows[0]["timestamp"];

                return [
                    "databaseName"      => $databaseName,
                    "databaseUser"      => $databaseUser,
                    "databasePassword"  => $databasePassword,
                    "databaseIPR"       => $databaseIPR,
                    "databaseTimestamp" => $databaseTimestamp
                ];
            } else {
                return [];
            }
    }

    private function selectDatabaseConfiguration() {
        $stmt = $this->dbPslzmeConfigStmtPreparer->prepareSelectPslzmeDBConfig();

        try {
            $result = $stmt->execute();

            if (!$result) {
                throw new DatabaseException("Unable to execute statement prepareSelectPslzmeDBConfig.");
            } 

            // Fetch all rows
            $rows = $result->fetchAllAssoc();


            return [
                'rows' => $rows,
                'numRows' => $result->numRows
            ];
        } catch (DatabaseException $dbe) {
            // rethrow 
            throw $dbe;
        }
    }

    private function updateDatabaseConfiguration($databaseName, $databaseUser, $databasePW, $timestamp) {
        $stmt = $this->dbPslzmeConfigStmtPreparer->prepareUpdatePslzmeDBConfig();

        try {
            $stmt->execute($databaseName, $databaseUser, $databasePW, $timestamp);
        
            if ($stmt->affectedRows > 0) {
                return "Sucessfully updated pslzme database data.";
            } else {
                throw new DatabaseException("Statement prepareUpdatePslzmeDBConfig executed successful but rows affected = 0");
            }
          
        } catch (DatabaseException $dbe) {
            // rethrow 
            throw $dbe;
        }
    }

    private function updateInternalPagesData($internalPages) {
        $stmt = $this->dbPslzmeConfigStmtPreparer->prepareUpdateInternalPages();

        try {
            $stmt->execute($internalPages);
        
            if ($stmt->affectedRows > 0) {
                return "Sucessfully updated pslzme internal pages data.";
            } else {
                throw new DatabaseException("Statement prepareUpdateInternalPages executed successful but rows affected = 0");
            }
          
        } catch (DatabaseException $dbe) {
            // rethrow 
            throw $dbe;
        }
    }


    private function insertDatabaseConfiguration($databaseName, $databaseUser, $databasePW, $timestamp) {
        $stmt = $this->dbPslzmeConfigStmtPreparer->prepareInsertPslzmeDBConfig();

        try {
            $stmt->execute($databaseName, $databaseUser, $databasePW, $timestamp);

            if ($stmt->affectedRows > 0) {
                return "Sucessfully inserted pslzme database data.";
            } else {
                throw new DatabaseException("Statement prepareInsertPslzmeDBConfig executed successful but rows affected = 0");
            }
        } catch (DatabaseException $dbe) {
            // rethrow 
            throw $dbe;
        }
    }
}
?>
