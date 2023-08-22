<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class UserService{
    
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(UserRequest $request) {
        
        $result = $this->userRepository->createUser($request);

        return $result;
    }

    public function loginUser(AuthRequest $request) {
        
        $credentials = $request->only('email', 'password');
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return ['message' => 'Credential Not Found','status' => 401];
            }

            return $this->responseToken($token);

        } catch (JWTException $e) {
            return ['error' => 'Could not create token', 'status' => 500];
        }

    }

    protected function responseToken($token)
    {
        return [
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
    
    
    
}

