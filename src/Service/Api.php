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

        $this->ciphering = "AES-128-CTR";
        $this->ivLength = openssl_cipher_iv_length($this->ciphering);
        $this->options = 0;
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


    function handleGreetingDataExtraction($requestData) {
        $encryptedFirstContact = str_replace(" ","+",rawurldecode($requestData->firstContact));
        $encryptedLinkCreator = str_replace(" ","+",rawurldecode($requestData->linkCreator));
        $timestamp = $requestData->timestamp;

        $respArr = array(
            "decryptedFirstContact" => "",
            "decryptedLinkCreator" => "",
            "response" => "",
         );

         try {
            // Create connection
            $db = new DatabaseConnection($this->servername, $this->username, $this->password, $this->dbname);
            $sqlExecutor = new DatabaseStatementExecutor($db);

            // Get the customer with its ID and its encrypt ID.
            $selectStmtResponse = $sqlExecutor->selectCustomerInformationCustomerDB();
            $respArr["response"] .= $selectStmtResponse["response"];
            $encryptionKey = $selectStmtResponse["encryptKey"];


            //decrypt the params
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            $decryption_iv = $timestamp;
            $decryptionKeyBin = hex2bin($encryptionKey);

            $decryptedFirstContact = openssl_decrypt($encryptedFirstContact, $ciphering, 
                        $decryptionKeyBin, $options, $decryption_iv);

            
            $decryptedLinkCreator = openssl_decrypt($encryptedLinkCreator, $ciphering, 
                        $decryptionKeyBin, $options, $decryption_iv);

            $respArr["decryptedFirstContact"] = $decryptedFirstContact;
            $respArr["decryptedLinkCreator"] = $decryptedLinkCreator;



        } catch(Exception $e) {
            $respArr["response"] .= "Error while trying to use database: " . $e;
        } finally {
            $db->closeConnection();
        }

        return $respArr;
    }
}

?>