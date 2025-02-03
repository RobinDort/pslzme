<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use RobinDort\PslzmeLinks\Service\Api;


class RequestHandlerController {

    #[Route('/requestHandler', name: 'request_handler', defaults: ['_scope' => 'backend'],  methods: ['POST'])]
    public function handleRequests(Request $request): JsonResponse {
        $postData = json_decode($request->getContent(), true);
        
        if (!isset($postData['request']) || !isset($postData['data'])) {
            return new JsonResponse(["error" => "Invalid request format"], 400);
        }

        $requestFunction = $postData['request'];
        $requestData = json_decode($postData['data'], true);

        $api = new Api();
        $response = [];

        switch ($requestFunction) {
            case "query-acception":
                $resp = $api->handleQueryAcception($requestData);
                $response = $resp;
            break;

            case "query-lock-check":
                $resp = $api->handleQueryLockCheck($requestData);
                $response = $resp;
            break;

            case "extract-greeting-data":
                $resp = $api->handleGreetingDataExtraction($requestData);
                $response = $resp;
                break;

            case "compare-link-owner":
                $resp = $api->handleCompareLinkOwner($requestData);
                $response = $resp;
                break;

            default:
                return new JsonResponse("Request does not match one of the provided availabilities");
        }

        return new JsonResponse($response);
    }
}

?>