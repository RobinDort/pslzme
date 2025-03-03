<?php
namespace RobinDort\PslzmeLinks\Service\Backend;


class DatabasePslzmeConfigStmtPreparer {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function prepareSelectPslzmeDBConfig() {
        $sqlQuery = "SELECT * FROM tl_pslzme_config";
        $stmt = $this->connection->prepare($sqlQuery);
        return $stmt;
    }

    public function prepareUpdatePslzmeDBConfig() {
        $sqlQuery = "UPDATE tl_pslzme_config SET pslzme_db_name = ?, pslzme_db_user = ?, pslzme_db_pw = ?";
        $stmt = $this->connection->prepare($sqlQuery);
        return $stmt;
    }


    public function prepareInsertPslzmeDBConfig() {
        $sqlQuery = "INSERT INTO tl_pslzme_config (pslzme_db_name, pslzme_db_user, pslzme_db_pw, timestamp) VALUES (?,?,?,?)";
        $stmt = $this->connection->prepare($sqlQuery);
        return $stmt;
    }

}


?>