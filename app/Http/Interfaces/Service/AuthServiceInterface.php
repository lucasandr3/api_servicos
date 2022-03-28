<?php

namespace App\Http\Interfaces\Service;

interface AuthServiceInterface
{
    public function register(object $request);

    public function login(object $request);

    public function refresh();
}
