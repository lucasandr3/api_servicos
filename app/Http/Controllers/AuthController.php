<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $service;

    public function __construct
    (
        AuthServiceInterface $service
    )
    {
//        $this->middleware('auth', ['except' => ['login', 'register']]);
        $this->service = $service;
    }

    public function register(Request $request)
    {
        return $this->service->register($request);
    }

    public function login(Request $request)
    {
        return $this->service->login($request);
    }

    public function validateToken()
    {
        $user = auth()->user();

        if($user) {
            return response()->json($user);
        } else {
            return $this->logout();
        }
    }

    public function logout()
    {
        auth()->logout();
        return 'Unauthorized';
    }

    public function unauthorized()
    {
        return response()->json('Unauthorizwed', 401);
    }
}
