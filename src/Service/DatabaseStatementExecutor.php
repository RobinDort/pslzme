<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\StatementPreparer;
use RobinDort\PslzmeLinks\Service\DatabaseConnection;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;


class DatabaseStatementExecutor {
    private $dbConn;
    private $statementPreparer;

    public function __construct(DatabaseConnection $db) {
        try {
            $this->dbConn = $db;
            $this->statementPreparer = new StatementPreparer($this->dbConn->getConnection());
        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    /****************************************** PUBLIC FUNCTIONS ******************************************/

    public function selectCustomerInformationCustomerDB() {
        $resp = "";
        $selectCustomerDBCustomerResp = $this->selectCustomerDBCustomer();

        $resp .= $selectCustomerDBCustomerResp->response;
        $customerID = $selectCustomerDBCustomerResp->presentCustomer->KundenID;

        // customer ID extracted. Now extract the encrypt ID and Key.
        $selectCustomerDBEncryptionResp = $this->selectCustomerEncryption($customerID);
        
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
            throw new InvalidDataException("Unable to extract customerID out of data object");
        }

        $encryptID = $data["encryptID"];
        if ($encryptID === null) {
            throw new InvalidDataException("Unable to extract encryptID out of data object");
        }

        $timestamp = $data["timestamp"];
        if ($timestamp === null) {
            throw new InvalidDataException("Unable to extract timestamp out of data array");
        }

        //select the query and check if it is accepted or not
        $selectCustomerDBCookieAcceptanceResp = $this->selectCustomerDBCookieAcceptance($customerID, $encryptID, $timestamp);

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


    public function insertCustomer($data) {
        $customer = $data["customer"];
        if ($customer === null) {
            throw new InvalidDataException("Unable to extract customer out of data array");
        }

        $resp = "";

        // check if customer already exists
        $selectCustomerResp = $this->selectCustomerDBCustomer();
        if (!empty($selectCustomerResp->presentCustomer)) {
            $resp = "Customer has already been saved to the database";
            return $resp;
        }

        $insertQueryResp = $this->insertCustomerQuery($customer);

        return $resp;
    }


   public function insertCustomerDBQuery($data) {
        $resp = "";

        $query = $data["query"];
        if ($query === null) {
            throw new InvalidDataException("Unable to extract query out of data object");
        }

        $timestamp = $data["timestamp"];
        if ($timestamp === null) {
            throw new InvalidDataException("Unable to extract timestamp out of data object");
        }

        $acceptedOn = $data["acceptedOn"];
        if ($acceptedOn === null) {
            throw new InvalidDataException("Unable to extract acception time out of data object");
        }

        $queryLocked = $data["queryLocked"];
        if ($queryLocked === null) {
            throw new InvalidDataException("Unable to extract query locked out of data object");
        }

        $cookieAccepted = $data["cookieAccepted"];
        if ($cookieAccepted === null) {
            throw new InvalidDataException("Unable to extract cookie acception out of data object");
        }

        $customerID = $data["customerID"];
        if ($customerID === null) {
            throw new InvalidDataException("Unable to extract customer ID out of data object");
        }

        $encryptID = $data["encryptID"];
        if ($encryptID === null) {
            throw new InvalidDataException("Unable to extract encryption ID out of data object");
        }

        // first check if the query already exists -> user has declined or accepted the cookie before
        $selectCustomerDBQueryStringResp = $this->selectCustomerDBQueryString($timestamp, $customerID, $encryptID);

        // select statement has been executed successfully and the query is not present
        if ($selectCustomerDBQueryStringResp->overwriteQuery === false) {

            $resp .= $selectCustomerDBQueryStringResp->response;

            // insert the new query
            $insertCustomerDBQueryStringResp = $this->insertCustomerDBQueryString($query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

            $resp .= $insertCustomerDBQueryStringResp->response;

        // select statement has been executed successfully but the query is already present and must be overwritten 
        } else if ($selectCustomerDBQueryStringResp->overwriteQuery === true) {

            $resp .= $selectCustomerDBQueryStringResp->response;

            // update the query
            $updateCustomerDBQueryStringResp = $this->updateCustomerDBQueryString($timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

            $resp .= $updateCustomerDBQueryStringResp->response;
        } 

        return $resp;
    }


/****************************************** INTERNAL PRIVATE FUNCTIONS ******************************************/

   private function selectCustomerDBCustomer() {
        $presentCustomer = (object)[];
        $response = array(
            "response" => "",
            "presentCustomer" => $presentCustomer
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareSelectAllCustomer();

        try {
            if ($stmt->execute()) {
                $stmtResult = $stmt->get_result();
                if ($stmtResult->num_rows === 0) {
                    throw new DatabaseException("selectAllCustomer returned rows = 0. Customer has not been initialized yet");
                } else {
                    $convertedResponse->response = "Customer has been found";
                    $convertedResponse->presentCustomer = $stmtResult->fetch_object();
                }

            } else {
                throw new DatabaseException("Unable to execute statement selectAllCustomer");
            } 

        } catch(Exception $e) {
            // Rethrow so api can handle catching.
            throw $e;
        } finally {
            if ($stmt) $stmt->close();
        }
        return $convertedResponse;
    }


    private function selectCustomerEncryption($customerID) {
        $queryWithKey = (object) [];
        $response = array(
            "response" => "",
            "queryWithKey" => $queryWithKey
        );

        $convertedResponse = (object)$response;

        $stmt = $this->statementPreparer->prepareSelectCustomerKey($customerID);

        try {
            if ($stmt->execute()) {
                $stmtResult = $stmt->get_result();
                if ($stmtResult->num_rows === 0) {
                    throw new DatabaseException("prepareSelectCustomerKey returned rows = 0. Encryption Key for customer with ID: " . $customerID . " does not exist");
                } else {
                    $convertedResponse->response = "Encryption key for customer with ID: " . $customerID . " found";
                    $convertedResponse->queryWithKey = $stmtResult->fetch_object();
                }

            } else {
                throw new DatabaseException("Unable to execute statement selectCustomerKey with customer ID: " . $customerID);
            } 

        } catch(Exception $e) {
            // rethrow so api can handle catching.
            throw $e;
        } finally {
            if ($stmt) $stmt->close();
        }
        return $convertedResponse;
    }


    private function selectCustomerDBQueryString($timestamp, $customerID, $encryptID) {
        $response = array(
            "response" => "",
            "overwriteQuery" => false,
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareSelectCustomerQuery($timestamp, $customerID, $encryptID);

        try {
            if ($stmt->execute()) {
                $stmtResult = $stmt->get_result();
                if ($stmtResult->num_rows === 0) {
                    $convertedResponse->response = "No query found. new query can safely be inserted into the database";
                } else {
                    $convertedResponse->response = "Found already present query. Query needs to be overwritten.";
                    $convertedResponse->overwriteQuery = true;
                }
            
            } else {
                throw new DatabaseException("Unable to execute statement selectCustomerQuery with timestamp: " . $timestamp . ", customer ID: " . $customerID . ", encryption ID: " . $encryptID);
            } 

        } catch(Exception $e) {
            // rethrow so api can handle catching.
            throw $e;
        } finally {
            if ($stmt) $stmt->close();
        }
        return $convertedResponse;
    }


    private function selectCustomerDBCookieAcceptance($customerID, $encryptID, $timestamp) {
        $response = array(
            "response" => "",
            "cookieAccepted" => false,
            "queryLocked" => false
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareSelectCustomerQuery($timestamp, $customerID, $encryptID);

        try {
            if ($stmt->execute()) {
                $convertedResponse->response = "Successfully selected customer query for customer ID: " . $customerID . " and encryption ID: " . $encryptID;

                $stmtResult = $stmt->get_result();
                $row = $stmtResult->fetch_assoc();

                // check if the query already exists in db
                if ($row) {
                    $cookieAccepted = $row["Accepted"];
                    $queryLocked = $row["Locked"];
                    if ($cookieAccepted === 1) {
                        $convertedResponse->cookieAccepted = true;
                    }
                    if ($queryLocked === 1) {
                        $convertedResponse->queryLocked = true;
                    }
                }
            
            } else {
                throw new DatabaseException("Unable to execute statement selectCustomerQuery with customer ID: " . $customerID . ", encryption ID: " . $encryptID);
            } 

        } catch(Exception $e) {
            //rethrow so api can handle catching
            throw $e;
        } finally {
            if ($stmt) $stmt->close();
        }
        return $convertedResponse;
    }


    private function insertCustomerQuery($customer) {
        $response = array(
            "response" => "",
        );
        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareInsertCustomer($customer);

    }


    private function insertCustomerDBQueryString($query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked) {
        $response = array(
            "response" => "",
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareInsertCustomerQuery($query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

        try {
            if ($stmt->execute()) {
                $convertedResponse->response = "Successfully inserted new query for customer ID: " . $customerID . " and encryption ID: " . $encryptID;            
            } else {
                throw new DatabaseException("Unable to execute query insertCustomerQuery with customer ID: " . $customerID . ", encryption ID: " . $encryptID);
            } 

        } catch(Exception $e) {
           // rethrow so api can handle catching.
           throw $e;
        } finally {
            if ($stmt) $stmt->close();
        }
        return $convertedResponse;
    }


    private function updateCustomerDBQueryString($timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked) {
        $response = array(
            "response" => "",
        );

        $convertedResponse = (object)$response;
        $stmt = $this->statementPreparer->prepareUpdateCustomerQuery($timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);

        try {
            if ($stmt->execute()) {
                $convertedResponse->response = "Successfully updated query for timestamp: " . $timestamp . "and customer ID: " . $customerID . " and encryption ID: " . $encryptID;
            
            } else {
                throw new DatabaseException("Unable to execute statement updateCustomerQuery with timestamp: " . $timestamp . ", customer ID: " . $customerID . ", encryption ID: " . $encryptID);
            } 

        } catch(Exception $e) {
            // rethrow so api can handle catching.
            throw $e;
        } finally {
            if ($stmt) $stmt->close();
        }
        return $convertedResponse;
    }
}
?>