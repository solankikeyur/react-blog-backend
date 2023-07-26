<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        try {
            return $this->getSuccessResponse([]);
        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {

            $params = $request->validated();
            User::create($params);
            return $this->getSuccessResponse(["message" => "Your registration was successfull."]);
        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {

            $tokenRepository = app(TokenRepository::class);
            $refreshTokenRepository = app(RefreshTokenRepository::class);

            $userTokens = $tokenRepository->forUser(auth()->user()->id);
            foreach ($userTokens as $token) {
                // Revoke an access token...
                $tokenRepository->revokeAccessToken($token->id);
                // Revoke all of the token's refresh tokens...
                $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
            }

            return $this->getSuccessResponse(["message" => "Logout successsfull."]);
        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }

    public function changePassword(ChangePasswordRequest $request) {
        try {

            $newPassword = $request->password;
            $user = auth()->user();
            if(Hash::check($newPassword, $user->password)) {
                throw new Exception("Please user different password.");
            }
            $user->update(["password" => $newPassword]);

            return $this->getSuccessResponse(["message" => "Password updated."]);

        } catch (Exception $e) {
            return $this->getFailureResponse($e->getMessage());
        }
    }
}
