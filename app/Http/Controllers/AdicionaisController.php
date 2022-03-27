<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\ProdutosServiceInterface;

class AdicionaisController extends Controller
{
    private $service;

    public function __construct
    (
        ProdutosServiceInterface $service
    )
    {
        $this->service = $service;
    }

    public function menu()
    {
        return $this->service->menu();
    }
}
