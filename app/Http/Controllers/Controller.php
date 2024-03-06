<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function responseSuccess($message, $data = null): JsonResponse
    {
        return self::completeResponse($message, $data);
    }

    public static function responseError($message, \Throwable $error = null): JsonResponse
    {
        return self::completeResponse($message, null, 200, $error ?? new \ErrorException($message));
    }


    public static function completeResponse($message = "", $data = null, $success = 200, \Throwable $error = null, $pagination = null, $attach = null): JsonResponse
    {
        $response = [
            'success' => !($success == 200 && isset($error)),
            'message' => $message
        ];

        if (isset($data)) {
            $response['data'] = $data;
        }

        if (isset($error)) {
            $response['error'] = $error->getMessage();
            $response['line'] = $error->getLine();
            $response['trace'] = $error->getTrace();
        }

        if (isset($pagination)) {
            $response['pagination'] = $pagination;
        }
        if (isset($attach)) {
            $response['attach'] = $attach;
        }
        return response()->json($response, $success);
    }
}
