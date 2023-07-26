<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use Exception;

class UserController extends ApiController
{
    public function getProfile()
    {
        try {

            $user = auth()->user();
            return $this->getSuccessResponse([
                "name" => $user->name,
                "email" => $user->email
            ]);
        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {

            $request->user()->update($request->validated());
            return $this->getSuccessResponse(["message" => "Profile Updated"]);

        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }
}
