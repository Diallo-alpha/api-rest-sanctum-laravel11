<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Fonction qui affiche un message de succès pour la réponse JSON.
     *
     * @param string|null $message
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success(?string $message = null, array $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => "success",
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Fonction qui affiche un message d'erreur pour la réponse JSON.
     *
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(?string $message = null, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => "error",
            'message' => $message,
        ], $statusCode);
    }
}
