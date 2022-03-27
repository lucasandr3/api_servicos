<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\CategoriaRepositoryInterface;
use App\Http\Interfaces\Service\CategoriaServiceInterface;

class CategoriaService implements CategoriaServiceInterface
{
    private $repository;

    public function __construct
    (
        CategoriaRepositoryInterface $repository
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
