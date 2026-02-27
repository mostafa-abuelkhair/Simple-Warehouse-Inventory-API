<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\DTO\LoginDto;
use App\DTO\RegisterDto;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {}

    public function register(RegisterRequest $request): TokenResource
    {
        $data = $this->authService->register(RegisterDto::fromArray($request->validated()));

        return new TokenResource($data);
    }

    public function login(LoginRequest $request): TokenResource
    {
        $data = $this->authService->login(LoginDto::fromArray($request->validated()));

        return new TokenResource($data);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
