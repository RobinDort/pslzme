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

    /****************************************** PUBLIC FUNCTIONS ******************************************/

    public function selectCustomerInformationCustomerDB() {
        $resp = "";
        $selectCustomerDBCustomerResp = $this->selectCustomerDBCustomer();

        if ($selectCustomerDBCustomerResp->executionSuccessful === false) {
            $resp .= $selectCustomerDBCustomerResp->response;
            return $resp;
        }

        $resp .= $selectCustomerDBCustomerResp->response;
        $customerID = $selectCustomerDBCustomerResp->presentCustomer->KundenID;

        // customer ID extracted. Now extract the encrypt ID and Key.
        $selectCustomerDBEncryptionResp = $this->selectCustomerEncryption($customerID);

        if ($selectCustomerDBEncryptionResp->executionSuccessful === false) {
            $resp .= $selectCustomerDBEncryptionResp->response;
            return $resp;
        }
        
        $resp .= $selectCustomerDBEncryptionResp->response;

        $encryptionID = $selectCustomerDBEncryptionResp->queryWithKey->EncryptionID;
        $encryptionKey = $selectCustomerDBEncryptionResp->queryWithKey->EncryptionKey;


        $respArr = array(
            "response" => $resp,
            "customerID" => $customerID,
            "encryptID" => $encryptionID,
            "encryptKey" => $encryptionKey
        );

       return $respArr;
   }



    public function selectQueryAcceptanceCustomerDB($data) {
        $resp = "";

        $customerID = $data["customerID"];
        if ($customerID === null) {
            $resp .= "Unable to extract customerID out of data array";
            return $resp;
        }

        $encryptID = $data["encryptID"];
        if ($encryptID === null) {
            $resp .= "Unable to extract encryptID out of data array";
            return $resp;
        }

        $timestamp = $data["timestamp"];
        if ($timestamp === null) {
            $resp .= "Unable to extract timestamp out of data array";
            return $resp;
        }

        //select the query and check if it is accepted or not
        $selectCustomerDBCookieAcceptanceResp = $this->selectCustomerDBCookieAcceptance($customerID, $encryptID, $timestamp);

        if ($selectCustomerDBCookieAcceptanceResp->executionSuccessful === false) {
            $resp .= $selectCustomerDBCookieAcceptanceResp->response;
            return $resp;
        }

        $resp .= $selectCustomerDBCookieAcceptanceResp->response;

        $cookieAccepted = $selectCustomerDBCookieAcceptanceResp->cookieAccepted;
        $queryLocked = $selectCustomerDBCookieAcceptanceResp->queryLocked;

        $respArr = array(
            "response" => $resp,
            "cookieAccepted" => $cookieAccepted,
            "queryLocked" => $queryLocked
        );

        return $respArr;
    }


   public function insertCustomerDBQuery($data) {
        $resp = "";

        $query = $data["query"];
        if ($query === null) {
            $resp .= "Unable to extract query out of data array";
            return $resp;
        }

        $timestamp = $data["timestamp"];
        if ($timestamp === null) {
            $resp .= "Unable to extract timestamp out of data array";
            return $resp;
        }

        $acceptedOn = $data["acceptedOn"];
        if ($acceptedOn === null) {
            $resp .= "Unable to extract acception time out of data array";
            return $resp;
        }

        $queryLocked = $data["queryLocked"];
        if ($queryLocked === null) {
            $resp .= "Unable to extract query locked out of data array";
            return $resp;
        }

        $cookieAccepted = $data["cookieAccepted"];
        if ($cookieAccepted === null) {
            $resp .= "Unable to extract cookie acception out of data array";
            return $resp;
        }

        $customerID = $data["customerID"];
        if ($customerID === null) {
            $resp .= "Unable to extract customer ID out of data array";
            return $resp;
        }

        $encryptID = $data["encryptID"];
        if ($encryptID === null) {
            $resp .= "Unable to extract encryption ID out of data array";
            return $resp;
        }

        // first check if the query already exists -> user has declined or accepted the cookie before
        $selectCustomerDBQueryStringResp = $this->selectCustomerDBQueryString($timestamp, $customerID, $encryptID);

        // select statement has been executed successfully and the query is not present
        if ($selectCustomerDBQueryStringResp->executionSuccessful === true && $selectCustomerDBQueryStringResp->overwriteQuery === false) {

            $resp .= $selectCustomerDBQueryStringResp->response;

            // insert the new query
            $insertCustomerDBQueryStringResp = $this->insertCustomerDBQueryString($query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

            if ($insertCustomerDBQueryStringResp->executionSuccessful === false) {
                $resp .= $insertCustomerDBQueryStringResp->response;
                return $resp;
            }

            $resp .= $insertCustomerDBQueryStringResp->response;

        // select statement has been executed successfully but the query is already present and must be overwritten 
        } else if ($selectCustomerDBQueryStringResp->executionSuccessful && $selectCustomerDBQueryStringResp->overwriteQuery === true) {

            $resp .= $selectCustomerDBQueryStringResp->response;

            // update the query
            $updateCustomerDBQueryStringResp = $this->updateCustomerDBQueryString($timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

        if ($updateCustomerDBQueryStringResp->executionSuccessful === false) {
                $resp .= $updateCustomerDBQueryStringResp->response;
                return $resp;
            }

            $resp .= $updateCustomerDBQueryStringResp->response;

        // select statement could not be executed
        } else {
            $resp .= $selectCustomerDBQueryStringResp->response;
            return $resp;

        }

        return $resp;
    }


/****************************************** INTERNAL PRIVATE FUNCTIONS ******************************************/

   private function selectCustomerDBCustomer() {
        $presentCustomer = (object)[];
        $response = array(
            "executionSuccessful" => false,
            "response" => "",
            "presentCustomer" => $presentCustomer
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareSelectAllCustomer();

        try {
            if ($stmt->execute()) {
                $stmtResult = $stmt->get_result();
                if ($stmtResult->num_rows === 0) {
                    $convertedResponse->executionSuccessful = false;
                    $convertedResponse->response = "Customer has not been initialized yet";
                } else {
                    $convertedResponse->executionSuccessful = true;
                    $convertedResponse->response = "Customer has been found";
                    $convertedResponse->presentCustomer = $stmtResult->fetch_object();
                }

            } else {
                $convertedResponse->executionSuccessful = false;
                $convertedResponse->response = "Error while trying to select customer";
            } 

        } catch(Exception $e) {
            $convertedResponse->executionSuccessful = false;
            $convertedResponse->response = "Exception:" .$e;
        } finally {
            $stmt->close();
        }
        return $convertedResponse;
    }


    private function selectCustomerEncryption($customerID) {
        $queryWithKey = (object) [];
        $response = array(
            "executionSuccessful" => false,
            "response" => "",
            "queryWithKey" => $queryWithKey
        );

        $convertedResponse = (object)$response;

        $stmt = $this->statementPreparer->prepareSelectCustomerKey($customerID);

        try {
            if ($stmt->execute()) {
                $stmtResult = $stmt->get_result();
                if ($stmtResult->num_rows === 0) {
                    $convertedResponse->executionSuccessful = false;
                    $convertedResponse->response = "Encryption Key for customer with ID: " . $customerID . " does not exist";
                } else {
                    $convertedResponse->executionSuccessful = true;
                    $convertedResponse->response = "Encryption key for customer with ID: " . $customerID . " found";
                    $convertedResponse->queryWithKey = $stmtResult->fetch_object();
                }

            } else {
                $convertedResponse->executionSuccessful = false;
                $convertedResponse->response = "Error while trying to select encryption key for customer with ID: " . $customerID;
            } 

        } catch(Exception $e) {
            $convertedResponse->executionSuccessful = false;
            $convertedResponse->response = "Exception:" .$e;
        } finally {
            $stmt->close();
        }
        return $convertedResponse;
    }


    private function selectCustomerDBQueryString($timestamp, $customerID, $encryptID) {
        $response = array(
            "executionSuccessful" => false,
            "response" => "",
            "overwriteQuery" => false,
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareSelectCustomerQuery($timestamp, $customerID, $encryptID);

        try {
            if ($stmt->execute()) {
                $stmtResult = $stmt->get_result();
                if ($stmtResult->num_rows === 0) {
                    $convertedResponse->executionSuccessful = true;
                    $convertedResponse->response = "No query found. new query can safely be inserted into the database";
                } else {
                    $convertedResponse->executionSuccessful = true;
                    $convertedResponse->response = "Found already present query. Query needs to be overwritten.";
                    $convertedResponse->overwriteQuery = true;
                }
            
            } else {
                $convertedResponse->executionSuccessful = false;
                $convertedResponse->response = "Error while trying to select customer query with timestamp: " . $timestamp . " and customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            } 

        } catch(Exception $e) {
            $convertedResponse->executionSuccessful = false;
            $convertedResponse->response = "Exception:" .$e;
        } finally {
            $stmt->close();
        }
        return $convertedResponse;
    }


    private function selectCustomerDBCookieAcceptance($customerID, $encryptID, $timestamp) {
        $response = array(
            "executionSuccessful" => false,
            "response" => "",
            "cookieAccepted" => false,
            "queryLocked" => false
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareSelectCustomerQuery($timestamp, $customerID, $encryptID);

        try {
            if ($stmt->execute()) {
                $convertedResponse->executionSuccessful = true;
                $convertedResponse->response = "Successfully selected customer query for customer ID: " . $customerID . " and encryption ID: " . $encryptID;

                $stmtResult = $stmt->get_result();
                $row = $stmtResult->fetch_assoc();
                $cookieAccepted = $row["Accepted"];
                $queryLocked = $row["Locked"];
                if ($cookieAccepted === 1) {
                    $convertedResponse->cookieAccepted = true;
                }
                if ($queryLocked === 1) {
                    $convertedResponse->queryLocked = true;
                }
            
            } else {
                $convertedResponse->executionSuccessful = false;
                $convertedResponse->response = "Error while trying to select customer query for customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            } 

        } catch(Exception $e) {
            $convertedResponse->executionSuccessful = false;
            $convertedResponse->response = "Exception:" .$e;
        } finally {
            $stmt->close();
        }
        return $convertedResponse;
    }


    private function insertCustomerDBQueryString($query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked) {
        $response = array(
            "executionSuccessful" => false,
            "response" => "",
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareInsertCustomerQuery($query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

        try {
            if ($stmt->execute()) {
                $convertedResponse->executionSuccessful = true;
                $convertedResponse->response = "Successfully inserted new query for customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            
            } else {
                $convertedResponse->executionSuccessful = false;
                $convertedResponse->response = "Error while trying to insert customer query for customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            } 

        } catch(Exception $e) {
            $convertedResponse->executionSuccessful = false;
            $convertedResponse->response = "Exception:" .$e;
        } finally {
            $stmt->close();
        }
        return $convertedResponse;
    }


    private function updateCustomerDBQueryString($timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked) {
        $response = array(
            "executionSuccessful" => false,
            "response" => "",
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareUpdateCustomerQuery($timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

        try {
            if ($stmt->execute()) {
                $convertedResponse->executionSuccessful = true;
                $convertedResponse->response = "Successfully updated query for timestamp: " . $timestamp . "and customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            
            } else {
                $convertedResponse->executionSuccessful = false;
                $convertedResponse->response = "Error while trying to update customer query for timestamp: " . $timestamp . "and customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            } 

        } catch(Exception $e) {
            $convertedResponse->executionSuccessful = false;
            $convertedResponse->response = "Exception:" .$e;
        } finally {
            $stmt->close();
        }
        return $convertedResponse;
    }
}
?>