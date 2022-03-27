<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\CategoriaServiceInterface;

class CategoriaController extends Controller
{
    private $service;

    public function __construct
    (
        CategoriaServiceInterface $service
    )
    {
        $this->service = $service;
    }

    public function categorias()
    {
        return $this->service->categorias();
    }
}
