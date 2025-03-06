<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Contao\Database;
use Contao\Message;

use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;
use RobinDort\PslzmeLinks\Service\DatabaseManager;

#[AsController]
class BackendRequestHandlerController {


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
            $dbPslzmeStmtExecutor = new DatabasePslzmeConfigStmtExecutor();
            $result = $dbPslzmeStmtExecutor->initDatabaseConfigurationData($databaseName, $databaseUser, $encryptedPassword, $timestamp);

            // init the pslzme database tables
            $dbm = new DatabaseManager();
            $dbm->initTables();

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
            $dbPslzmeStmtExecutor = new DatabasePslzmeConfigStmtExecutor();
            $result = $dbPslzmeStmtExecutor->saveInternalPagesData($jsonPages);

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


    private function encryptPassword($password, $timestamp) {
        $secretKey = hash('sha256', $timestamp); // Create a key from the timestamp
        $iv = random_bytes(16); // Generate IV
    
        $ciphertext = openssl_encrypt($password, 'aes-256-cbc', $secretKey, 0, $iv);
        $encryptedData = base64_encode($iv . $ciphertext);
    
        return $encryptedData;
    }
}

?>