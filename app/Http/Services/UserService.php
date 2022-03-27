<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\UserRepositoryInterface;
use App\Http\Interfaces\Service\UserServiceInterface;

class UserService implements UserServiceInterface
{
    private $repository;

    public function __construct
    (
        UserRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function categorias()
    {
        $categorias = $this->repository->categorias()->toArray();

        $categorias = array_map(function ($categoria) {
            $categoria['status'] = Helpers::status($categoria['status']);
            return $categoria;
        }, $categorias);

        return $categorias;
    }
}
