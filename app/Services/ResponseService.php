<?php

namespace App\Services;

use Illuminate\Http\Response;

class ResponseService
{

    /**
     * @param array $data
     */
    public static function success(array $data)
    {

    }

    /**
     * @param $message
     * @param $code
     */
    public static function fail($message, $code)
    {
        return response()->json([
            'message' => $message,
            'code'    => $code,
        ], Response::HTTP_OK);

    }

}
