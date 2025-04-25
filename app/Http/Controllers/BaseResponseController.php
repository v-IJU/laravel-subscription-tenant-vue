<?php

namespace App\Http\Controllers;

use App\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class BaseResponseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json($this->makeResponse($message, $result));
    }

    public function sendError($error, $code = 422)
    {
        return Response::json($this->makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json(
            [
                "success" => true,
                "message" => $message,
            ],
            200
        );
    }

    public function makeResponse($message, $data)
    {
        return [
            "success" => true,
            "data" => $data,
            "message" => $message,
        ];
    }

    public function makeError($message, array $data = [])
    {
        $res = [
            "success" => false,
            "message" => $message,
        ];

        if (!empty($data)) {
            $res["data"] = $data;
        }

        return $res;
    }
}
