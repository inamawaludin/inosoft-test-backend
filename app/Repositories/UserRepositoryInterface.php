<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\UserRequest;

interface UserRepositoryInterface
{
    public function createUser(UserRequest $request);
    public function getUsers();
    public function findUser($_id);
}