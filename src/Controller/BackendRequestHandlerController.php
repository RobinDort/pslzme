<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class BackendRequestHandlerController {

    #[Route('/saveDatabaseData', name: "save_database_data")]
    public function saveDatabaseData(Request $request): JsonResponse {
        $requestData = $request->request->get('data');
        return new JsonResponse($requestData);
    }

}

?>