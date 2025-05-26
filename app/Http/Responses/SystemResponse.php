<?php
namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Class SystemResponse
 * Sistem genelinde kullanılacak standart JSON yanıtlarını yöneten sınıf.
 */

class SystemResponse
{
    public static function success($data = null, $message = 'İşlem başarılı'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ] , 200);
    }

    public static function error($error, $code = 500): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $error,
            'data' => null,
        ], $code);
    }
}