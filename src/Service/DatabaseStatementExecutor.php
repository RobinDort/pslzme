<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\StatementPreparer;

class DatabaseStatementExecutor {
    private $dbConn;
    private $statementPreparer;

    public function __construct(DatabaseConnection $db) {
        $this->dbConn = $db;
        $this->statementPreparer = new StatementPreparer($this->dbConn->getConnection());
    }
}
?>