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
     * Response with internal server error
     */
    public static function fail()
    {
        return response()->json([
            'message' => "something went wrong!!",
            'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
        ], Response::HTTP_OK);

    }

    /**
     * Response with internal server error
     */
    public static function notFound($type)
    {
        return response()->json([
            'message' => sprintf("there is no %s available!!", $type),
            'code'    => Response::HTTP_NOT_FOUND,
        ], Response::HTTP_OK);

    }
    /**
     * Response with internal server error
     */
    public static function unavailable($type)
    {
        return response()->json([
            'message' => sprintf("%s is not available!!", $type),
            'code'    => Response::HTTP_NOT_FOUND,
        ], Response::HTTP_OK);

    }

    /**
     * Response with internal server error
     */
    public static function unauthenticated()
    {
        return response()->json([
            'message' => "you are not authenticated for this request.",
            'code'    => Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED,
        ], Response::HTTP_OK);

    }

}
