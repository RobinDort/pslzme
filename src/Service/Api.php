<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;
use RobinDort\PslzmeLinks\Service\DatabaseStatementExecutor;

class Api {

    private $db;
    private $sqlExecutor;

    private $ciphering;
    private $ivLength;
    private $options;

    public function __construct(DatabaseConnection $dbConn) {
        // create / inject database connection
        $this->db = $dbConn;
        $this->sqlExecutor = new DatabaseStatementExecutor($this->db);
    }

    function handleQueryAcception($requestData) {
        $linkCreator = $requestData->linkCreator;
        $title = $requestData->title;
        $firstname = $requestData->firstname;
        $lastname = $requestData->lastname;
        $company = $requestData->company;
        $companyGender = $requestData->companyGender;
        $gender = $requestData->gender;
        $position = $requestData->position;
        $curl = $requestData->curl;
        $fc = $requestData->fc;
        $cookieAccepted = $requestData->cookieAccepted;
        $timestamp = $requestData->timestamp;
        $acceptedOn = time();

        $queryLocked = $requestData->queryIsLocked;

        $dbResponses = "";

        try {
            // Get the customer with its ID and its encrypt ID.
            $selectStmtResponse = $sqlExecutor->selectCustomerInformationCustomerDB();

            $dbResponses .= $selectStmtResponse["response"];
            $customerID = $selectStmtResponse["customerID"];
            $encryptID = $selectStmtResponse["encryptID"];

            $insertQueryData = array(
                    "query" => "?q1=" . $linkCreator . "&q2=" . $title . "&q3=" . $firstname . "&q4=" . $lastname . "&q5=" . $company . "&q6=" . $gender . "&q7=" . $position . "&q8=" . $curl . "&q9=" . $fc . "&q10=" . $timestamp . "&q11=" . $companyGender,
                    "timestamp" => $timestamp,
                    "acceptedOn" => $acceptedOn,
                    "cookieAccepted" => $cookieAccepted,
                    "queryLocked" => $queryLocked,
                    "customerID" => $customerID,
                    "encryptID" => $encryptID
                );

             $insertStmtResponse = $sqlExecutor->insertCustomerDBQuery($insertQueryData);
             $dbResponses .= $insertStmtResponse;
        } catch(Exception $e) {
            $dbResponses .=  "Error while trying to use database: " . $e;
            echo $dbResponses;
        } finally {
            $db->closeConnection();
        }

        return $dbResponses;
    }


    function handleQueryLockCheck($requestData) {
        $timestamp = $requestData->timestamp;

        $respArr = array(
            "response" => "",
            "queryIsLocked" => false
        );

        try {
             // Get the customer with its ID and its encrypt ID.
             $selectStmtResponse = $sqlExecutor->selectCustomerInformationCustomerDB();

             $respArr["response"] .= $selectStmtResponse["response"];
             $customerID = $selectStmtResponse["customerID"];
             $encryptID = $selectStmtResponse["encryptID"];

             $secondSelectData = array(
                "timestamp" => $timestamp,
                "customerID" => $customerID,
                "encryptID" => $encryptID
             );

            $secondSelectStmtResponse = $sqlExecutor->selectQueryAcceptanceCustomerDB($secondSelectData);
            $queryLocked = $secondSelectStmtResponse["queryLocked"];
            $respArr["queryIsLocked"] = $queryLocked;
        } catch(Exception $e) {
            $respArr["response"] .= "Error while trying to use database: " . $e;
        } finally {
            $db->closeConnection();
        }

        return $respArr;
    }

}

?>