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

        try {
            $databaseName = $requestData->dbName;
            $databaseUser = $requestData->dbUsername;
            $databasePassword = $requestData->dbPW;

            if (!$databaseName || !$databaseUser || !$databasePassword) {
                throw new InvalidDataException("Unable to extract database information out of request object");
            }

            // encrypt the password before saving
           // $encryptedPassword = Encryption::encrypt($databasePassword);

            // save the database data into the pslzme config table
            //$result = Database::getInstance()->prepare("INSERT INTO tl_pslzme_config (pslzme_db_name, pslzme_db_user, pslzme_db_pw) VALUES (?,?,?)")->execute($databaseName, $databaseUser, $encryptedPassword);

            if ($result->affectedRows > 0) {
                return new JsonResponse("Sucessfully inserted pslzme database data.");
            } else {
                throw new DatabaseException("Unable to insert pslzme configuration data into tl_pslzme_config table");
            }
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

}

?>