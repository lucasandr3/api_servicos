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

    public function categorias()
    {
        return $this->service->categorias();
    }
}
