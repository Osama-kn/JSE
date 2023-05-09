<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    protected function successResponse($data, $message = null, $code = 200, $statut = "Success", $params = []): JsonResponse
    {
        return response()->json(
            [
                'status' => $statut,
                'message' => $message,
                'code' => $code,
                'data' => $data,
                'params' => $params
            ],
            $code,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_SLASHES
        );
    }

    protected function errorResponse($message = "An error has occured !", $code = 400, $trace = null): JsonResponse
    {
        return response()->json(
            [
                'status' => 'Error',
                'message' => $message,
                'code' => $code,
                'trace' => $trace,
                'data' => null
            ],
            $code,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    protected function confirmResponse($data, $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'Confirm',
            'message' => $message,
            'code' => $code,
            'data' => $data
        ], $code);
    }
}