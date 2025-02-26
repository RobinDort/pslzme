<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Contao\Database;
use Contao\Encryption;

use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;

#[AsController]
class BackendRequestHandlerController {

    #[Route('/saveDatabaseData', name: "save_database_data")]
    public function saveDatabaseData(Request $request): JsonResponse {
        $requestData = $request->request->get('data');
        try {
            $databaseName = $requestData->dbName;
            $databaseUser = $requestData->dbUsername;
            $databasePassword = $requestData->dbPW;

            if (!$databaseName || !$databaseUser || !$databasePassword) {
                throw new InvalidDataException("Unable to extract database information out of request object");
            }

            // encrypt the password before saving
            $encryptedPassword = Encryption::encrypt($databasePassword);

            // save the database data into the pslzme config table
        } catch (InvalidDataException $ide) {
            error_log($ide->getErrorMsg());
        }

        return new JsonResponse($encryptedPassword);
    }

}

?>