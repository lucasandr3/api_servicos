<?php


namespace App\Http\Interfaces\Repository;


interface ProdutosRepositoryInterface
{
    public function produtos();

    public function adicionais($produto);

    public function produtoById(int $produto);
}
