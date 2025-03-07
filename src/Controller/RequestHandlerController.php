<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use RobinDort\PslzmeLinks\Service\Api;


#[Route('/requestHandler', name: RequestHandlerController::class)]
#[AsController]
class RequestHandlerController {

    private $api;

    // public function __construct(Api $api) {
    //     $this->api = $api;
    // }

    public function __construct() {
        $this->api = new Api();
    }

    public function __invoke(Request $request): JsonResponse {
        $requestData = $request->request->get('data');
        $requestFunction = $request->request->get('request');
        
        if (!isset($requestData) || !isset($requestFunction)) {
            return new JsonResponse(["error" => "post data[request] or postdata[data] not set!"], 400);
        }

         $response = [];

        switch ($requestFunction) {
            case "query-acception":
                $resp = $this->api->handleQueryAcception($requestData);
                $response = $resp;
            break;

            case "query-lock-check":
                $resp = $this->api->handleQueryLockCheck($requestData);
                $response = $resp;
            break;

            case "extract-greeting-data":
                $resp = $this->api->handleGreetingDataExtraction($requestData);
                $response = $resp;
                break;

            case "compare-link-owner":
                $resp = $this->api->handleCompareLinkOwner($requestData);
                $response = $resp;
                break;

            default:
                return new JsonResponse("Request does not match one of the provided availabilities");
        }

         return new JsonResponse($response);
    }
}

?>