<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;
use RobinDort\PslzmeLinks\Service\DatabaseStatementExecutor;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Exceptions\InvalidDecryptionException;


use Exception;

class Api {

    private $db;
    private $sqlExecutor;

    private $ciphering;
    private $ivLength;
    private $options;

    // public function __construct(DatabaseConnection $dbConn) {
    //     // create / inject database connection
    //     $this->db = $dbConn;
    //     $this->sqlExecutor = new DatabaseStatementExecutor($this->db);

    //     $this->ciphering = "AES-128-CTR";
    //     $this->ivLength = openssl_cipher_iv_length($this->ciphering);
    //     $this->options = 0;
    // }


    public function __construct() {
        // create / inject database connection
        $this->db = new DatabaseConnection();
        $this->sqlExecutor = new DatabaseStatementExecutor($this->db);

        $this->ciphering = "AES-128-CTR";
        $this->ivLength = openssl_cipher_iv_length($this->ciphering);
        $this->options = 0;
    }


    function handleQueryAcception($requestData) {
        $requestData = json_decode($requestData, false);

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

        $respArr = array(
            "response" => "",
        );
        
        try {
            // Start transaction to secure all operations.
            $this->db->getConnection()->begin_transaction();

            // Get the customer with its ID and its encrypt ID.
            $selectStmtResponse = $this->sqlExecutor->selectCustomerInformationCustomerDB();

            $respArr["response"] .= $selectStmtResponse["response"];
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

             $insertStmtResponse = $this->sqlExecutor->insertCustomerDBQuery($insertQueryData);
             $respArr["response"] .= $insertStmtResponse;

            // Commit transaction to make both operations successful.
            $this->db->getConnection()->commit();

        } catch(InvalidDataException $ide) {
            $this->db->getConnection()->rollback();
            error_log($ide->getErrorMsg());
        } catch(DatabaseException $dbe) {
            $this->db->getConnection()->rollback();
            error_log($dbe->getErrorMsg());
        } catch(Exception $e) {
            $this->db->getConnection()->rollback();
            error_log($e->getMessage());
        } finally {
            if (isset($this->db)) {
                $this->db->closeConnection();
            }
        }

        return $respArr;
    }


    function handleQueryLockCheck($requestData) {
        $requestData = json_decode($requestData, false);

        $timestamp = $requestData->timestamp;

        $respArr = array(
            "response" => "",
            "queryIsLocked" => false
        );

        try {
            // Start transaction to secure all operations.
            $this->db->getConnection()->begin_transaction();

             // Get the customer with its ID and its encrypt ID.
             $selectStmtResponse = $this->sqlExecutor->selectCustomerInformationCustomerDB();

             $respArr["response"] .= $selectStmtResponse["response"];
             $customerID = $selectStmtResponse["customerID"];
             $encryptID = $selectStmtResponse["encryptID"];

             $secondSelectData = array(
                "timestamp" => $timestamp,
                "customerID" => $customerID,
                "encryptID" => $encryptID
             );

            $secondSelectStmtResponse = $this->sqlExecutor->selectQueryAcceptanceCustomerDB($secondSelectData);
            $queryLocked = $secondSelectStmtResponse["queryLocked"];
            $respArr["queryIsLocked"] = $queryLocked;

            // Commit transaction to make both operations successful.
            $this->db->getConnection()->commit();
        } catch(InvalidDataException $ide) {
            $this->db->getConnection()->rollback();
            error_log($ide->getErrorMsg());
        } catch(DatabaseException $dbe) {
            $this->db->getConnection()->rollback();
            error_log($dbe->getErrorMsg());
        } catch(Exception $e) {
            $respArr["response"] .= "Error while trying to use database: " . $e;
        } finally {
            if (isset($this->db)) {
                $this->db->closeConnection();
            }
        }

        return $respArr;
    }


    function handleGreetingDataExtraction($requestData) {
        $requestData = json_decode($requestData, false);

        $encryptedFirstContact = str_replace(" ","+",rawurldecode($requestData->firstContact));
        $encryptedLinkCreator = str_replace(" ","+",rawurldecode($requestData->linkCreator));
        $timestamp = $requestData->timestamp;

        $respArr = array(
            "decryptedFirstContact" => "",
            "decryptedLinkCreator" => "",
            "response" => "",
         );

         try {
            // Get the customer with its ID and its encrypt ID.
            $selectStmtResponse = $this->sqlExecutor->selectCustomerInformationCustomerDB();
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

            // Decryption failed
            if ($decryptedFirstContact === false || !mb_check_encoding($decryptedFirstContact, 'UTF-8')) {
                throw new InvalidDecryptionException("Unable to decrypt first contact option");
            }
            
            $decryptedLinkCreator = openssl_decrypt($encryptedLinkCreator, $ciphering, 
                        $decryptionKeyBin, $options, $decryption_iv);

            // Decryption failed
            if ($decryptedLinkCreator === false || !mb_check_encoding($decryptedLinkCreator, 'UTF-8')) {
                throw new InvalidDecryptionException("Unable to decrypt link creator option");
            }

            $respArr["decryptedFirstContact"] = $decryptedFirstContact;
            $respArr["decryptedLinkCreator"] = $decryptedLinkCreator;

        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
            $respArr["response"] = $dbe->getErrorMsg();
        } catch (InvalidDecryptionException $idece) {
            error_log($idece->getErrorMsg());
            $respArr["response"] = $idece->getErrorMsg();
        } catch(Exception $e) {
            $respArr["response"] .= "Error while trying to use database: " . $e->getMessage();
        } finally {
            if (isset($this->db)) {
                $this->db->closeConnection();
            }
        }

        return $respArr;
    }



    function handleCompareLinkOwner($requestData) {
        $requestData = json_decode($requestData, false);

        $combinedNameInput = $requestData->firstInput . $requestData->secondInput . $requestData->thirdInput;
        $timestamp = $requestData->timestamp;
        $encryptedLastName = str_replace(" ","+",rawurldecode($requestData->encryptedLastName));

        $respArr = array(
            "nameMatchesOwner" => false,
            "response" => "",
        );


        try {
            // Get the customer with its ID and its encrypt ID.
            $selectStmtResponse = $this->sqlExecutor->selectCustomerInformationCustomerDB();
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

            $respArr["response"] .= "Last Name: " . $decryptedLastName;


            if ($this->compareStrings($decryptedLastName, $combinedNameInput)) {
                $respArr["nameMatchesOwner"] = true;
            } else {
                $respArr["response"] .= "unable to compare strings";
            }

        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
        } catch(Exception $e) {
            $respArr["response"] .= "Error while trying to use database: " . $e;
        } finally {
            if (isset($this->db)) {
                $this->db->closeConnection();
            }
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