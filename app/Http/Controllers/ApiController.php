<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getSuccessResponse($data) {

        try {
            return response()->json(["data" => $data, "code" => 200]);

        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage(), "code" => 500]);
        }

    }

    public function getFailureResponse($message) {
        try {

            return response()->json(["message" => $message, "code" => 500]);

        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage(), "code" => 500]);
        }
    }
}
