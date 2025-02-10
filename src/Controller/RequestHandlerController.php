<?php
namespace RobinDort\PslzmeLinks\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use RobinDort\PslzmeLinks\Service\Api;


class RequestHandlerController {

    private $api;

    public function __construct(Api $api) {
        $this->api = $api;
    }

    #[Route('/requestHandler', name: 'request_handler', defaults: ['_token_check' => true, '_scope' => 'frontend'],  methods: ['POST'])]
    public function handleRequests(Request $request): JsonResponse {
        $postData = json_decode($request->getContent(), true);
        
        if (!isset($postData['request']) || !isset($postData['data'])) {
            return new JsonResponse(["error" => "Invalid request format"], 400);
        }

        $requestFunction = $postData['request'];
        $requestData = json_decode($postData['data'], true);

        $response = ["test"];

        switch ($requestFunction) {
            case "query-acception":
                $resp = $this->$api->handleQueryAcception($requestData);
                $response = $resp;
            break;

            case "query-lock-check":
                $resp = $this->$api->handleQueryLockCheck($requestData);
                $response = $resp;
            break;

            case "extract-greeting-data":
                $resp = $this->$api->handleGreetingDataExtraction($requestData);
                $response = $resp;
                break;

            case "compare-link-owner":
                $resp = $this->$api->handleCompareLinkOwner($requestData);
                $response = $resp;
                break;

            default:
                return new JsonResponse("Request does not match one of the provided availabilities");
        }

        return new JsonResponse($response);
    }
}

?>