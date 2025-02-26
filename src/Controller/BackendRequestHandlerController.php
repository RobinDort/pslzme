<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BackendRequestHandlerController {

    #[Route('/saveDatabaseData', name: "save_database_data")]
    public function saveDatabaseData(Request $request): JsonResponse {
        return new JsonResponse("success");
    }

}

?>