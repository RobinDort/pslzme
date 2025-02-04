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
}
?>