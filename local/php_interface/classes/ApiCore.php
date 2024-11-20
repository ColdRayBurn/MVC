<?php

namespace Activitar;

use Activitar\Dto\JsonResponse;
use Bitrix\Main\Context;
use JsonException;
use Random\RandomException;

trait ApiCore
{

    public string $token = '';

    protected function checkBearerToken(): array|int
    {
        $headers = getallheaders();
        $headers = array_change_key_case($headers, CASE_LOWER);

        if (!isset($headers['authorization'])) {
            http_response_code(400);
            return ['errorMessage' => 'Bad Request: access token not found'];
        }

        $token = explode(' ', $headers['authorization'])[1];
        $this->token = $token;
        $user = UserService::getUserByToken($token);

        if ($user['success'] !== 1) {
            http_response_code(400);
            return ['errorMessage' => 'Bad Request: access denied, user not found or not authorized'];
        }

        return $user['data']['ID'];
    }

    /**
     * @throws RandomException
     */
    protected function generateUuidV4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        if (empty($_SESSION['UUID'])) {
            $_SESSION['UUID'] = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        return $_SESSION['UUID'];
    }


    protected function executeApi(): void
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
            header("HTTP/1.1 200 OK");
            die();
        }
    }

    protected function getRequestParams(string $param): array|string|null|int|float
    {
        $context = Context::getCurrent();
        $request = $context->getRequest();

        if ($request->get($param) !== null) {
            return $request->get($param);
        }

        return null;
    }


    protected function getParams(): array
    {
        $requestBody = file_get_contents("php://input");
        return json_decode($requestBody, true) ?? [];
    }


    /**
     * @param array $result
     * @param array $params
     * @param array $pageProperties - если хотим сделать вехрнее меню белым - в контроллере нужно передать сюда ['top_menu' => Activitar\View::EXCLUSIVE_COLOR_MENU]
     * @return void
     */
    protected function sendDataToView(array $result, array $params, array $pageProperties = []): void
    {
        $viewData = ViewData::getInstance();
        $viewData->setResult($result);
        $viewData->setParams($params);
        $viewData->setPageProperties($pageProperties);
    }
}