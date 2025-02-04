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



    function handleCompareLinkOwner($requestData) {
        $combinedNameInput = $requestData->firstInput . $requestData->secondInput . $requestData->thirdInput;
        $timestamp = $requestData->timestamp;
        $encryptedLastName = str_replace(" ","+",rawurldecode($requestData->encryptedLastName));

        $respArr = array(
            "nameMatchesOwner" => false,
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

            $decryptedLastName = openssl_decrypt($encryptedLastName, $ciphering, 
                        $decryptionKeyBin, $options, $decryption_iv);


            if ($this->compareStrings($decryptedLastName, $combinedNameInput)) {
                $respArr["nameMatchesOwner"] = true;
            } else {
                $respArr["response"] .= "unable to compare strings";
            }

        } catch(Exception $e) {
            $respArr["response"] .= "Error while trying to use database: " . $e;
        } finally {
            $db->closeConnection();
        }

        return $respArr;
    }


    private function compareStrings($str1, $str2) {

        // Convert both strings to lowercase
        $strToLower1 = mb_strtolower($str1, "UTF-8");
        $strToLower2 = mb_strtolower($str2, "UTF-8");
    
        // Get the lengths of the strings
        $len1 = strlen($strToLower1);
        $len2 = strlen($strToLower2);
    
        // Check if the lengths are at least 3 characters
        if ($len1 < 3 || $len2 < 3) {
            return false;
        }
    
        // Compare the first 3 characters
        for ($i = 0; $i < 3; $i++) {
            $currentCharOfStr1 = mb_substr($strToLower1,$i,1);
            $currentCharOfStr2 = mb_substr($strToLower2,$i,1);
            if ($currentCharOfStr1 !== $currentCharOfStr2) {
                return false;
            }
            // if (strcmp($strToLower1[$i],$strToLower2[$i]) !== 0) {
            //     return false;
            // }
        }
    
        // If all characters match, return true
        return true;
    }
}

?>