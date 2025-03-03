<?php
namespace RobinDort\PslzmeLinks\Service\Backend;

use Contao\Database;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtPreparer;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;

class DatabasePslzmeConfigStmtExecutor {
    private $connection;
    private $dbPslzmeConfigStmtPreparer;

    public function __construct() {
        $this->connection = Database::getInstance();
        $this->dbPslzmeConfigStmtPreparer = new DatabasePslzmeConfigStmtPreparer($this->connection);
    }

    public function initDatabaseConfigurationData($databaseName, $databaseUser, $databasePW, $timestamp) {
         // check if database options are already saved
         $selectResult = $this->selectDatabaseConfiguration();

         if ($selectResult > 0) {
            // database data has been found. Update it.
            $updateResult = $this->updateDatabaseConfiguration($databaseName, $databaseUser, $databasePW);
            return $updateResult;
         } else {
            // no database data found. Insert the new data
            // save the database data into the pslzme config table
            $insertResult = $this->insertDatabaseConfiguration($databaseName, $databaseUser, $databasePW, $timestamp);
            return $insertResult;
         }
    }

    private function selectDatabaseConfiguration() {
        $stmt = $this->dbPslzmeConfigStmtPreparer->prepareSelectPslzmeDBConfig();

        try {
            $result = $stmt->execute();

            if (!$result) {
                throw new DatabaseException("Unable to execute statement prepareSelectPslzmeDBConfig.");
            } 

            return $result->numRows;
        } catch (DatabaseException $dbe) {
            // rethrow 
            throw $dbe;
        }
    }

    private function updateDatabaseConfiguration($databaseName, $databaseUser, $databasePW) {
        $stmt = $this->dbPslzmeConfigStmtPreparer->prepareUpdatePslzmeDBConfig();

        try {
            $stmt->execute($databaseName, $databaseUser, $databasePW);
        
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
