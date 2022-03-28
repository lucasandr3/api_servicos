<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\UserServiceInterface;

class UserController extends Controller
{
    private $service;

    public function __construct
    (
        UserServiceInterface $service
    )
    {
        $this->service = $service;
    }

    public function read()
    {
        $user = [
            'id' => auth()->user()->getAuthIdentifier(),
            'name' => auth()->user()['name'],
            'avatar' => url('media/avatars/'.auth()->user()['avatar']),
            'email' => auth()->user()['email']
        ];

        return ['error' => '', 'data' => $user];
    }
}
