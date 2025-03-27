<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Contao\Database;
use Contao\Message;
use Contao\System;

use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Service\DatabaseStatementExecutor;
use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;
use RobinDort\PslzmeLinks\Service\DatabaseManager;
use RobinDort\PslzmeLinks\Service\DatabaseConnection;

/**
 * Class that handles backend request from the pslzme configuration module
 */
#[AsController]
class BackendRequestHandlerController {

    private $dbPslzmeStmtExecutor;
    private $dbPslzmeConfigStmtExecutor;
    private $databaseManager;


    /**
     * constructor 
     */
    public function __construct() {
        $this->dbPslzmeStmtExecutor = System::getContainer()->get(DatabasePslzmeConfigStmtExecutor::class);
        $this->databaseManager = System::getContainer()->get(DatabaseManager::class);

        $doctrineConnection = System::getContainer()->get("database_connection");
        $this->dbPslzmeConfigStmtExecutor = new DatabasePslzmeConfigStmtExecutor($doctrineConnection);
    }


    /**
     * function will save the users database information assigned in the backend module to the contao database pslzme_config table.
     * @request: request object that contains the users previously created database name, username and password.
     * @returns An JsonResponse object containing messages from the different database functions.  
     */
    #[Route('/saveDatabaseData', name: "save_database_data", defaults: ['_token_check' => true, '_scope' => 'backend'],  methods: ['POST'])] 
    public function saveDatabaseData(Request $request): JsonResponse {
        $requestData = $request->request->get('data');

        try {
            $requestData = json_decode($requestData, false);

            if (!$requestData) {
                throw new InvalidDataException("Unable to extract request data out of /saveDatabaseData object");
            }

            $databaseName = $requestData->dbName;
            $databaseUser = $requestData->dbUsername;
            $databasePassword = $requestData->dbPW;


            if (!$databaseName || !$databaseUser || !$databasePassword) {
                throw new InvalidDataException("Unable to extract database information out of request object");
            }

            // encrypt the password before saving
            $timestamp = time();
            $encryptedPassword = $this->encryptPassword($databasePassword,$timestamp);

            // use database and insert or update the data
            $result = $this->dbPslzmeStmtExecutor->initDatabaseConfigurationData($databaseName, $databaseUser, $encryptedPassword, $timestamp);

            Message::addConfirmation($result);
            return new JsonResponse($result);

        } catch (InvalidDataException $ide) {
            error_log($ide->getErrorMsg());
            return new JsonResponse($ide->getErrorMsg());
        } catch(DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
            return new JsonResponse($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
            return new JsonResponse($e->getMessage());
        }
    }

    /**
     * function will insert a new pslzme customer to the pslzme database that has been created manually by the user.
     * NOTE: This database is NOT the usual contao database but a seperate one manually created.
     * @request: request object containing information about the pslzme customer like his company name e.g
     * @returns An JsonResponse object containing messages from the different database functions.  
     */
    #[Route('/registerCustomer', name: "register_customer", defaults: ['_token_check' => true, '_scope' => 'backend'],  methods: ['POST'])]
    public function registerCustomer(Request $request): JsonResponse {
        $requestData = $request->request->get('data');
        try {
            $requestData = json_decode($requestData, true);

            // get the database connection to the pslzme database
            $databaseConnection = new DatabaseConnection($this->dbPslzmeStmtExecutor);
            $dbStmtExcecutor = new DatabaseStatementExecutor($databaseConnection);

            $resp = "";

            // start transaction so all operations are made sure to be saved into the db.
            $databaseConnection->getConnection()->begin_transaction();
            $insertCustomerResult = $dbStmtExcecutor->insertCustomer($requestData);

            if ($insertCustomerResult["customerID"] === 0) {
                $databaseConnection->getConnection()->commit();
                return new JsonResponse($insertCustomerResult["response"]);
            }

            $resp .= $insertCustomerResult["response"];
            $customerID = $insertCustomerResult["customerID"];
            $insertKeyData = array(
                "key"           => $requestData["key"],
                "customerID"    => $customerID
            );

            $insertKeyResult = $dbStmtExcecutor->insertCustomerKey($insertKeyData);
            $resp .= $insertKeyResult;

            // update the config db to set the license configuration to true
            $this->dbPslzmeConfigStmtExecutor->updateUrlLicenseRegistration();
            
            $databaseConnection->getConnection()->commit();
            return new JsonResponse($resp);

        } catch (InvalidDataException $ide) { 
            if (isset($databaseConnection)) {
                $databaseConnection->getConnection()->rollback();
            }
            error_log($ide->getErrorMsg());
            return new JsonResponse($ide->getErrorMsg());
        } catch (DatabaseException $dbe) { 
            if (isset($databaseConnection)) {
                $databaseConnection->getConnection()->rollback();
            }
            error_log($dbe->getErrorMsg());
            return new JsonResponse($dbe->getErrorMsg());
        } catch (Exception $e) {
            if (isset($databaseConnection)) {
                $databaseConnection->getConnection()->rollback();
            }
            error_log($e->getMessage());
            return new JsonResponse($e->getMessage());
        } finally {
            if ($databaseConnection) {
                $databaseConnection->closeConnection();
            }
        }

    }

    /**
     * function that will initialize all needed database tables for the manually from the user created pslzme database.
     * @returns An JsonResponse informing about the successful creation of the tables. 
     */
    #[Route('/createPslzmeTables', name: "create_pslzme_tables", defaults: ['_token_check' => true, '_scope' => 'backend'],  methods: ['POST'])] 
    public function createPslzmeTables(): JsonResponse {
        try {
            $this->databaseManager->initTables();
            return new JsonResponse("Tables created successfully");
        } catch (Exception $e) {
            error_log($e->getMessage());
            return new JsonResponse($e->getMessage());
        }

    }

    /**
     * function that saves IDs from the users website that link to the imprint as well as the privacy policy into the pslzme_config table from the contao database 
     * @request: request object containing the IDs.
     * @returns An JsonResponse object containing messages from the different database functions.  
     */
    #[Route('/saveInternalPages', name: "save_internal_pages", defaults: ['_token_check' => true, '_scope' => 'backend'],  methods: ['POST'])] 
    public function saveInternalPages(Request $request): JsonResponse {
        $requestData = $request->request->get('data');

        try {
            $requestData = json_decode($requestData, false);

            if (!$requestData) {
                throw new InvalidDataException("Unable to extract request data out of /saveInternalPages object");
            }

            $imprintID = $requestData->imprintID;
            $privacyID = $requestData->privacyID;
            $homeID = $requestData->homeID;

            $combinedInternalPages = [
                "Imprint"   => $imprintID,
                "Privacy"   => $privacyID,
                "Home"      => $homeID
            ];
            $jsonPages = json_encode($combinedInternalPages);

            // save the pages into the database
            $result = $this->dbPslzmeStmtExecutor->saveInternalPagesData($jsonPages);

            Message::addConfirmation($result);
            return new JsonResponse($result);

        } catch (InvalidDataException $ide) {
            error_log($ide->getErrorMsg());
            Message::addError($ide->getErrorMsg());
            return new JsonResponse($ide->getErrorMsg());
        } catch(DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
            Message::addError($dbe->getErrorMsg());
            return new JsonResponse($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
            Message::addError($e->getMessage());
            return new JsonResponse($e->getMessage());
        }
        return new JsonResponse("");
    }


    /**
     * function that encrypts the users database password for the manually created pslzme database so that the password will not be readable.
     * @password: the users database password
     * @timestamp: a unix timestamp used to encrypt the password.
     */
    private function encryptPassword($password, $timestamp) {
        $secretKey = hash('sha256', $timestamp, true); // Create a key from the timestamp
        $iv = random_bytes(16); // Generate IV
    
        $ciphertext = openssl_encrypt($password, 'aes-256-cbc', $secretKey, 0, $iv);
        $encryptedData = base64_encode($iv . $ciphertext);
    
        return $encryptedData;
    }

}


?>