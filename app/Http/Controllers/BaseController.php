<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * Send a success response.
     *
     * @param  string|array $data
     * @param  int $status
     * @return \Illuminate\Http\Response
     */
    protected function sendSuccessResponse($data = null, $status = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $status);
    }

    /**
     * Send an error response.
     *
     * @param  string $message
     * @param  int $status
     * @return \Illuminate\Http\Response
     */
    protected function sendErrorResponse($data = null, $status = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'error' => $data
        ], $status);
    }
}
