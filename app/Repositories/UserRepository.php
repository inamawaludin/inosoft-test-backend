<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser(UserRequest $request)
    {
        try {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->save();

            return [
                'status' => 201,
                'message' => 'User successfully created!',
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 500,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getUsers()
    {
        return $this->user->get();
    }

    public function findUser($_id)
    {
        return $this->user->find($_id);
    }
}
