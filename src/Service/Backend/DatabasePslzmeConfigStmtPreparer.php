<?php
namespace RobinDort\PslzmeLinks\Service\Backend;


class DatabasePslzmeConfigStmtPreparer {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function prepareSelectPslzmeDBConfig() {
        $stmt = "SELECT * FROM tl_pslzme_config";
        $this->connection->prepare($stmt);
        return $stmt;
    }

    public function prepareUpdatePslzmeDBConfig($databaseName, $databaseUser, $databasePW) {
        $stmt = "UPDATE tl_pslzme_config SET pslzme_db_name = ?, pslzme_db_user = ?, pslzme_db_pw = ?";
        $this->connection->prepare($stmt);
        $stmt->bind_param("sss", $databaseName, $databaseUser, $databasePW);

        return $stmt;
    }


    public function prepareInsertPslzmeDBConfig($databaseName, $databaseUser, $databasePW, $timestamp) {
        $stmt = "INSERT INTO tl_pslzme_config (pslzme_db_name, pslzme_db_user, pslzme_db_pw, timestamp) VALUES (?,?,?,?)";
        $this->connection->prepare($stmt);
        $stmt->bind_param("sssi", $databaseName, $databaseUser, $databasePW, $timestamp);

        return $stmt;
    }

}


?>