<?php

namespace App\Http\Interfaces\Repository;

interface AuthRepositoryInterface
{
    public function registerUser(object $request);

    public function loginUser(array $credentials);
}
