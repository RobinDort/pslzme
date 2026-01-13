<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;
use RobinDort\PslzmeLinks\Service\DatabaseStatementExecutor;

use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Exceptions\InvalidDecryptionException;


class DecryptFormData {

    private $db;
    private $sqlExecutor;


    private $encryptedLinkCreator = "";
    private $encryptedTitle = "";
    private $encryptedFirstName ="";
    private $encryptedLastName = "";
    private $encryptedGender = "";
    private $encryptedAddress = "";
    private $encryptedHousenumber = "";
    private $encryptedPostcode = "";
    private $encryptedPlace = "";
    private $encryptedCountry = "";
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
    private $decryptedAddress = "";
    private $decryptedHousenumber = "";
    private $decryptedPostcode = "";
    private $decryptedPlace = "";
    private $decryptedCountry = "";
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

        $requiredParams = ["q1", "q3", "q4", "q5", "q6", "q7", "q9", "q11"];

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

        if (isset($_GET["q12"])) {
            $this->encryptedAddress = str_replace(" ","+",rawurldecode($_GET["q12"]));
        }

        if (isset($_GET["q13"])) {
            $this->encryptedHousenumber = str_replace(" ","+",rawurldecode($_GET["q13"]));
        }

        if (isset($_GET["q14"])) {
            $this->encryptedPostcode = str_replace(" ","+",rawurldecode($_GET["q14"]));
        }

        if (isset($_GET["q15"])) {
            $this->encryptedPlace = str_replace(" ","+",rawurldecode($_GET["q15"]));
        }

        if (isset($_GET["q16"])) {
            $this->encryptedCountry = str_replace(" ","+",rawurldecode($_GET["q16"]));
        }

        $requiredParamsSet = $this->checkForRequiredParams($requiredParams);

       if ($requiredParamsSet) {
            try {
                // Get the customer with its ID and its encrypt ID.
                $selectStmtResponse = $this->sqlExecutor->selectCustomerInformationCustomerDB();
                $customerID = $selectStmtResponse["customerID"];
                $encryptID = $selectStmtResponse["encryptID"];
                $encryptionKey = $selectStmtResponse["encryptKey"];

                throw new \Exception("Debugging ->" . $customerID . " " . $encryptID . " " . $encryptionKey);
            
                //check if the customer has given permission to decrypt his data.
                $cookieQueryData = array(
                    "customerID" => $customerID,
                    "encryptID" => $encryptID,
                    "timestamp" => $this->timestamp
                );

                
                $selectCookieResp = $this->sqlExecutor->selectQueryAcceptanceCustomerDB($cookieQueryData);
                $cookieAccepted = $selectCookieResp["cookieAccepted"];
            
                $cookie = isset($_COOKIE["consent_cookie"]) ? $_COOKIE["consent_cookie"] : null;

                if ($cookie !== null) {
                    $cookieData = json_decode($cookie, true);
                    
                    //only decrypt when the user has given permission and the cookie is set
                    if ($selectCookieResp["cookieAccepted"] === true && $cookieData["accepted"] === true) {
                        
                        //decrypt the params
                        $ciphering = "AES-128-CTR";
                        $iv_length = openssl_cipher_iv_length($ciphering);
                        $options = 0;
                        // $decryption_iv = $this->timestamp;
                        $decryption_iv = substr(hash('sha256', $timestamp, true), 0, 16);
                        $decryptionKeyBin = hex2bin($encryptionKey);
                
                        $this->decryptedLinkCreator = openssl_decrypt ($this->encryptedLinkCreator, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedLinkCreator === false || !mb_check_encoding($this->decryptedLinkCreator, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt link creator option");
                        }
                
                        $this->decryptedTitle = openssl_decrypt ($this->encryptedTitle, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedTitle === false || !mb_check_encoding($this->decryptedTitle, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt title option");
                        }
                
                        $this->decryptedFirstName = openssl_decrypt ($this->encryptedFirstName, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedFirstName === false || !mb_check_encoding($this->decryptedFirstName, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt first name option");
                        }
                
                        $this->decryptedLastName = openssl_decrypt ($this->encryptedLastName, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        
                        if ($this->decryptedLastName === false || !mb_check_encoding($this->decryptedLastName, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt last name option");
                        }
                
                        $this->decryptedCompanyName = openssl_decrypt ($this->encryptedCompanyName, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedCompanyName === false || !mb_check_encoding($this->decryptedCompanyName, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt company name option");
                        }
                
                        $this->decryptedCompanyGender = openssl_decrypt ($this->encryptedCompanyGender, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);
                                    
                        if ($this->decryptedCompanyGender === false || !mb_check_encoding($this->decryptedCompanyGender, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt company gender option");
                        }
                
                        $this->decryptedGender = openssl_decrypt ($this->encryptedGender, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedGender === false || !mb_check_encoding($this->decryptedGender, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt gender option");
                        }
                
                        $this->decryptedPosition = openssl_decrypt ($this->encryptedPosition, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedPosition === false || !mb_check_encoding($this->decryptedPosition, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt position option");
                        }
                
                        $this->decryptedCurl = openssl_decrypt ($this->encryptedCurl, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedCurl === false || !mb_check_encoding($this->decryptedCurl, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt url option");
                        }
                
                        $this->decryptedFC = openssl_decrypt ($this->encryptedFC, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedFC === false || !mb_check_encoding($this->decryptedFC, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt first contact option");
                        }

                        $this->decryptedAddress = openssl_decrypt ($this->encryptedAddress, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedAddress === false || !mb_check_encoding($this->decryptedAddress, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt address option");
                        }

                        $this->decryptedHousenumber = openssl_decrypt ($this->encryptedHousenumber, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedHousenumber === false || !mb_check_encoding($this->decryptedHousenumber, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt housenumber option");
                        }

                        $this->decryptedPostcode = openssl_decrypt ($this->encryptedPostcode, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedPostcode === false || !mb_check_encoding($this->decryptedPostcode, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt postcode option");
                        }

                        $this->decryptedPlace = openssl_decrypt ($this->encryptedPlace, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedPlace === false || !mb_check_encoding($this->decryptedPlace, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt place option");
                        }

                        $this->decryptedCountry = openssl_decrypt ($this->encryptedCountry, $ciphering, 
                                    $decryptionKeyBin, $options, $decryption_iv);

                        if ($this->decryptedCountry === false || !mb_check_encoding($this->decryptedCountry, 'UTF-8')) {
                            throw new InvalidDecryptionException("Unable to decrypt country option");
                        }
                    }
                }
            
            } catch(InvalidDataException $ide) {
                error_log($ide->getErrorMsg());
            } catch(DatabaseException $dbe) {
                error_log($dbe->getErrorMsg());
            } catch(InvalidDecryptionException $idece) {
                error_log($idece->getErrorMsg());
            } catch(Exception $e) {
                error_log("Error while trying to use database: " . $e->getMessage());
            } 
        }
    }


    private function checkForRequiredParams($requiredParams) {
        foreach($requiredParams as $key) {
            if(!isset($_GET[$key])) {
                return false;
            }
        }
        return true;
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

    public function getDecryptedAddress() {
        return $this->decryptedAddress;
    }

    public function getDecryptedHousenumber() {
        return $this->decryptedHousenumber;
    }

    public function getDecryptedPostcode() {
        return $this->decryptedPostcode;
    }

    public function getDecryptedPlace() {
        return $this->decryptedPlace;
    }

    public function getDecryptedCountry() {
        return $this->decryptedCountry;
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