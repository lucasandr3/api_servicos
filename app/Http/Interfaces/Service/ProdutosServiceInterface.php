<?php


namespace App\Http\Interfaces\Service;


interface ProdutosServiceInterface
{
    public function menu();

    public function produtoById(int $produto);
}
