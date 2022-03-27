<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\ProdutosServiceInterface;
use Illuminate\Http\Request;

class ProdutosController extends Controller
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

    public function produto(int $produto)
    {
        return $this->service->ProdutoById($produto);
    }
}
