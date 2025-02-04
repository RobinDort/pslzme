<?php
namespace RobinDort\PslzmeLinks\Service;

class StatementPreparer {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function prepareSelectAllCustomer() {
        $sqlQuery = "SELECT * FROM pslzme_kunde"; 
        $stmt = $this->conn->prepare($sqlQuery);

        return $stmt;
    }

    public function prepareSelectCustomerKey($queryParamID) {
        $sqlQuery = "SELECT a.*, b.* FROM pslzme_kunde as a INNER JOIN encrypt_info AS b ON a.KundenID=b.PslzmeKundenID WHERE a.KundenID=?"; 
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("i", $queryParamID);

        return $stmt;
    }
}

?>