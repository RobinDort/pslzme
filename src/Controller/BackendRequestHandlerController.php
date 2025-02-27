<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Contao\Database;

use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;
use RobinDort\PslzmeLinks\Exceptions\DatabaseException;

#[AsController]
class BackendRequestHandlerController {

    #[Route('/saveDatabaseData', name: "save_database_data")]
    public function saveDatabaseData(Request $request): JsonResponse {
        $requestData = $request->request->get('data');
        $requestData = json_decode($requestData, false);

        if (!$requestData) {
            throw new InvalidDataException("Unable to extract request data out of /saveDatabaseData object");
        }

        try {
            $databaseName = $requestData->dbName;
            $databaseUser = $requestData->dbUsername;
            $databasePassword = $requestData->dbPW;


            if (!$databaseName || !$databaseUser || !$databasePassword) {
                throw new InvalidDataException("Unable to extract database information out of request object");
            }

            // encrypt the password before saving
            $timestamp = time();
            $encryptedPassword = $this->encryptPassword($databasePassword,$timestamp);
            return new JsonResponse($encryptedPassword);

            // // save the database data into the pslzme config table
            // $db = Database::getInstance();
            // if (!$db) {
            //     throw new DatabaseException("Unable to connect to contao database");
            // }

            // $result = $db->prepare("INSERT INTO tl_pslzme_config (pslzme_db_name, pslzme_db_user, pslzme_db_pw, timestamp) VALUES (?,?,?,?)")->execute($databaseName, $databaseUser, $encryptedPassword, $timestamp);

            // if ($result->affectedRows > 0) {
            //     return new JsonResponse("Sucessfully inserted pslzme database data.");
            // } else {
            //     throw new DatabaseException("Unable to insert pslzme configuration data into tl_pslzme_config table");
            // }
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


    private function encryptPassword($password, $timestamp) {
        $secretKey = hash('sha256', $timestamp); // Create a key from the timestamp
        $iv = random_bytes(16); // Generate IV
    
        $ciphertext = openssl_encrypt($password, 'aes-256-cbc', $secretKey, 0, $iv);
        $encryptedData = base64_encode($iv . $ciphertext);
    
        return $encryptedData;
    }  

    private function decryptPassword($encryptedPassword, $timestamp) {
        $secretKey = hash('sha256', $timestamp); // Recreate key from timestamp
        $data = base64_decode($encryptedPassword);
        
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        
        return openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);
    }
}

?>