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

    public function prepareSelectCustomerQuery($queryParamTimestamp, $queryParamCustomerID, $queryParamEncryptionID) {
        $sqlQuery = "SELECT * FROM query_link WHERE CreationTime=? AND PslzmeKundenID=? AND EncryptInfoID=?"; 
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("iii", $queryParamTimestamp, $queryParamCustomerID, $queryParamEncryptionID);

        return $stmt;
    }

    public function prepareUpdateCustomerQuery($queryParamTimestamp, $queryParamChangedOn, $queryParamCookieAccepted, $queryParamCustomerID, $queryParamEncryptionID, $queryParamQueryLocked) {
        $sqlQuery = "UPDATE query_link SET Accepted=?, Locked=?, ChangedOn=? WHERE CreationTime=? AND PslzmeKundenID=? AND EncryptInfoID=?"; 
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("iiiiii", $queryParamCookieAccepted, $queryParamQueryLocked, $queryParamChangedOn, $queryParamTimestamp, $queryParamCustomerID, $queryParamEncryptionID);

        return $stmt;
    }

    public function prepareInsertCustomerQuery($queryParamQuery, $queryParamTimestamp, $queryParamAcceptedOn, $queryParamCookieAccepted, $queryParamCustomerID, $queryParamEncryptionID, $queryParamQueryLocked) {
        $sqlQuery = "INSERT INTO query_link (QueryString, CreationTime, AcceptionTime, Accepted, Locked, PslzmeKundenID, EncryptInfoID) VALUES(?,?,?,?,?,?,?)"; 
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bind_param("siiiiii", $queryParamQuery, $queryParamTimestamp, $queryParamAcceptedOn, $queryParamCookieAccepted, $queryParamQueryLocked, $queryParamCustomerID, $queryParamEncryptionID);

        return $stmt;
    }
}

?>