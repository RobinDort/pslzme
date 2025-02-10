<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;

class DecryptFormData {

    private $db;
    private $sqlExecutor;


    private $encryptedLinkCreator = "";
    private $encryptedTitle = "";
    private $encryptedFirstName ="";
    private $encryptedLastName = "";
    private $encryptedGender = "";
    private $encryptedCompanyName = "";
    private $encryptedCompanyGender = "";
    private $encryptedPosition = "";
    private $encryptedCurl = "";
    private $encryptedFC = "";
    private $timestamp = 0;


    private $decryptedLinkCreator = "";
    private $decryptedTitle = "";
    private $decryptedFirstName = "";
    private $decryptedLastName = "";
    private $decryptedCompanyName = "";
    private $decryptedCompanyGender = "";
    private $decryptedGender = "";
    private $decryptedPosition = "";
    private $decryptedCurl = "";
    private $decryptedFC = "";

    public function __construct(DatabaseConnection $dbConn) {
         // create / inject database connection
         $this->db = $dbConn;
         $this->sqlExecutor = new DatabaseStatementExecutor($this->db);
    }

    public function decrypt() {
        // Get the encrypted get parameters. Important!: => after the rawurldecode function all the "+" chars are converted to spaces " ". This is the current URL norm.
        // Because the decryption relies especially on the + char, we need to replace the spaces with the + chars again before decrypting.

        if(isset($_GET["q1"])) {
            $this->encryptedLinkCreator = str_replace(" ","+",rawurldecode($_GET["q1"]));
        }

        if(isset($_GET["q2"])) {
            $this->encryptedTitle = str_replace(" ","+",rawurldecode($_GET["q2"]));
        }

        if (isset($_GET["q3"])) {
            $this->encryptedFirstName = str_replace(" ","+",rawurldecode($_GET["q3"]));
        }

        if (isset($_GET["q4"])) {
            $this->encryptedLastName = str_replace(" ","+",rawurldecode($_GET["q4"]));
        }

        if (isset($_GET["q5"])) {
            $this->encryptedCompanyName = str_replace(" ","+",rawurldecode($_GET["q5"]));
        }

        if (isset($_GET["q6"])) {
            $this->encryptedGender = str_replace(" ","+",rawurldecode($_GET["q6"]));
        }

        if (isset($_GET["q7"])) {
            $this->encryptedPosition = str_replace(" ","+",rawurldecode($_GET["q7"]));
        }

        if (isset($_GET["q8"])) {
            $this->encryptedCurl = str_replace(" ","+",rawurldecode($_GET["q8"]));
        }

        if (isset($_GET["q9"])) {
            $this->encryptedFC =str_replace(" ","+",rawurldecode($_GET["q9"]));
        }

        if (isset($_GET["q10"])) {
            $this->timestamp = $_GET["q10"];
        }

        if (isset($_GET["q11"])) {
            $this->encryptedCompanyGender = str_replace(" ","+",rawurldecode($_GET["q11"]));
        }

        try {
            // Get the customer with its ID and its encrypt ID.
            $selectStmtResponse = $this->sqlExecutor->selectCustomerInformationCustomerDB();
            $customerID = $selectStmtResponse["customerID"];
            $encryptID = $selectStmtResponse["encryptID"];
            $encryptionKey = $selectStmtResponse["encryptKey"];
        
            //check if the customer has given permission to decrypt his data.
            $cookieQueryData = array(
                "customerID" => $customerID,
                "encryptID" => $encryptID,
                "timestamp" => $this->timestamp
            );
            
            $selectCookieResp = $this->sqlExecutor->selectQueryAcceptanceCustomerDB($cookieQueryData);
            $cookieAccepted = $selectCookieResp["cookieAccepted"];
        
            $cookie = $_COOKIE["consent_cookie"];
            $cookieData = json_decode($cookie, true);
            
            //only decrypt when the user has given permission and the cookie is set
            if ($selectCookieResp["cookieAccepted"] === true && $cookieData["accepted"] === true) {
                
                //decrypt the params
                $ciphering = "AES-128-CTR";
                $iv_length = openssl_cipher_iv_length($ciphering);
                $options = 0;
                $decryption_iv = $timestamp;
                $decryptionKeyBin = hex2bin($encryptionKey);
        
                $this->decryptedLinkCreator = openssl_decrypt ($this->encryptedLinkCreator, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedTitle = openssl_decrypt ($this->encryptedTitle, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedFirstName = openssl_decrypt ($this->encryptedFirstName, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedLastName = openssl_decrypt ($this->encryptedLastName, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedCompanyName = openssl_decrypt ($this->encryptedCompanyName, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
           
                $this->decryptedCompanyGender = openssl_decrypt ($this->encryptedCompanyGender, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);       
        
                $this->decryptedGender = openssl_decrypt ($this->encryptedGender, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedPosition = openssl_decrypt ($this->encryptedPosition, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedCurl = openssl_decrypt ($this->encryptedCurl, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
        
                $this->decryptedFC = openssl_decrypt ($this->encryptedFC, $ciphering, 
                            $decryptionKeyBin, $options, $decryption_iv);
            }
        
        } catch(Exception $e) {
             error_log("Error while trying to use database: " . $e->getMessage());
        } finally {
            if (isset($this->db)) {
                $this->db->closeConnection();
            }
        }
    }

    /** Getter functions */
    public function getDecryptedLinkCreator() {
        return $this->decryptedLinkCreator;
    }

    public function getDecryptedTitle() {
        return $this->decryptedTitle;
    }

    public function getDecryptedFirstName() {
        return $this->decryptedFirstName;
    }

    public function getDecryptedLastName() {
        return $this->decryptedLastName;
    }

    public function getDecryptedCompanyName() {
        return $this->decryptedCompanyName;
    }

    public function getDecryptedCompanyGender() {
        return $this->decryptedCompanyGender;
    }

    public function getDecryptedGender() {
        return $this->decryptedGender;
    }

    public function getDecryptedPosition() {
        return $this->decryptedPosition;
    }

    public function getDecryptedCURL() {
        return $this->decryptedCurl;
    }

    public function getDecryptedFC() {
        return $this->decryptedFC;
    }
}

?>