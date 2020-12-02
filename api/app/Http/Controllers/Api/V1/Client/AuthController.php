<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Client\User\LoginRequest;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Services\Client\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * Create a new AuthController instance.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->validated();
        $this->authService->register($data);

        if (! $token = Auth::guard('client')->attempt($data)) {
            throw new UnauthorizedException(__('auth.failed'));
        }

        return $this->responseData($this->respondWithToken($token));
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $loginRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $loginRequest)
    {
        return $this->attemp($loginRequest->validated());
    }

    private function attemp($credentials)
    {
        if (! $token = auth()->guard('client')->attempt($credentials)) {
            throw new UnauthorizedException(__('auth.failed'));
        }

        return $this->responseData($this->respondWithToken($token));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->responseData(auth('client')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
