<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message = null, $result = null, $code = 200)
    {
    	$response = [
            'success' => true,
            'message' => $message ?? __('The request has been successful.'),
        ];

        if (!$result == null) {
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message = null, $errors = null, $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $message ?? __('Server Error'),
        ];

        if(!empty($errors)){
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
