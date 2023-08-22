<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function login(AuthRequest $request) {
        $response = $this->userService->loginUser($request);

        return response()->json($response,$response['status']);
    }

    public function register(UserRequest $request) {
        $response = $this->userService->registerUser($request);

        return response()->json($response,$response['status']);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }

}
