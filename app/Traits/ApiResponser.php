<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse($data, $code = 200, $message = null)
    {
        return response()->json([
            'status' => 'success',
            'massage' => $message,
            'data' => $data
        ], $code);
    }
    protected function errorResponse($code, $message = null)
    {
        return response()->json([
            'status' => 'Error',
            'massage' => $message,
            'data' => null
        ], $code);
    }
}
