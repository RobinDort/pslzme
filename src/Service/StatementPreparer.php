<?php
namespace RobinDort\PslzmeLinks\Service;

class StatementPreparer {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    /******************************* SELECT FUNCTIONS *******************************/

    public function prepareSelectAllCustomer() {
        $sqlQuery = "SELECT * FROM pslzme_kunde"; 
        $stmt = $this->conn->prepare($sqlQuery);

        return $stmt;
    }

    public function prepareSelectCustomerKey($queryParamID) {
        $sqlQuery = "SELECT a.*, b.* FROM pslzme_kunde as a INNER JOIN encrypt_info AS b ON a.KundenID=b.PslzmeKundenID WHERE a.KundenID=?"; 
        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindValue(1,$queryParamID,"integer");

        return $stmt;
    }

    public function prepareSelectCustomerQuery($queryParamTimestamp, $queryParamCustomerID, $queryParamEncryptionID) {
        $sqlQuery = "SELECT * FROM query_link WHERE CreationTime=? AND PslzmeKundenID=? AND EncryptInfoID=?"; 
        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindValue(1,$queryParamTimestamp,"integer");
        $stmt->bindValue(2,$queryParamCustomerID,"integer");
        $stmt->bindValue(3,$queryParamEncryptionID,"integer");

        return $stmt;
    }


    /******************************* UPDATE FUNCTIONS *******************************/

    public function prepareUpdateCustomerQuery($queryParamTimestamp, $queryParamChangedOn, $queryParamCookieAccepted, $queryParamCustomerID, $queryParamEncryptionID, $queryParamQueryLocked) {
        $sqlQuery = "UPDATE query_link SET Accepted=?, Locked=?, ChangedOn=? WHERE CreationTime=? AND PslzmeKundenID=? AND EncryptInfoID=?"; 
        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindValue(1,$queryParamCookieAccepted,"integer");
        $stmt->bindValue(2,$queryParamQueryLocked,"integer");
        $stmt->bindValue(3,$queryParamChangedOn,"integer");
        $stmt->bindValue(4,$queryParamTimestamp,"integer");
        $stmt->bindValue(5,$queryParamCustomerID,"integer");
        $stmt->bindValue(6,$queryParamEncryptionID,"integer");

        return $stmt;
    }


    /******************************* INSERT FUNCTIONS *******************************/

    public function prepareInsertCustomer($queryParamCustomer) {
        $sqlQuery = "INSERT INTO pslzme_kunde (Name) VALUES (?)";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindValue(1,$queryParamCustomer,"string");

        return $stmt;
    }

    public function prepareInsertCustomerKey($queryParamEncryptionKey, $queryParamCustomerID) {
        $sqlQuery = "INSERT INTO encrypt_info (EncryptionKey, PslzmeKundenID) VALUES (?,?)";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindValue(1,$queryParamEncryptionKey,"string");
        $stmt->bindValue(2,$queryParamCustomerID,"string");

        return $stmt;
    }

    public function prepareInsertCustomerQuery($queryParamQuery, $queryParamTimestamp, $queryParamAcceptedOn, $queryParamCookieAccepted, $queryParamCustomerID, $queryParamEncryptionID, $queryParamQueryLocked) {
        $sqlQuery = "INSERT INTO query_link (QueryString, CreationTime, AcceptionTime, Accepted, Locked, PslzmeKundenID, EncryptInfoID) VALUES(?,?,?,?,?,?,?)"; 
        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindValue(1,$queryParamQuery,"string");
        $stmt->bindValue(2,$queryParamTimestamp,"integer");
        $stmt->bindValue(3,$queryParamAcceptedOn,"integer");
        $stmt->bindValue(4,$queryParamCookieAccepted,"integer");
        $stmt->bindValue(5,$queryParamQueryLocked,"integer");
        $stmt->bindValue(6,$queryParamCustomerID,"integer");
        $stmt->bindValue(7,$queryParamEncryptionID,"integer");

        return $stmt;
    }
}

?>