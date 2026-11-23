<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function successResponse(string $message, mixed $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success'     => true,
            'message'     => $message,
            'data'        => $data,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    public function errorResponse(string $message, int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'success'     => false,
            'message'     => $message,
            'errors'      => $errors,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    public function paginatedResponse(string $message, mixed $data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success'     => true,
            'message'     => $message,
            'data'        => $data->items(),

            'meta'        =>[
                'current_page' => $data->currentPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
                'last_page'    => $data->lastPage(),
            ],

            'links'       => [
                'next' => $data->nextPageUrl(),
                'prev' => $data->previousPageUrl(),
            ],
            'status_code' => $statusCode,
        ]);
    }
}
