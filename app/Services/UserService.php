<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

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

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return ['message' => 'Credential Not Found','status' => 401];
        }

        return $this->responseToken($token);

    }

    protected function responseToken($token)
    {
        return [
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
    
    
    
}

