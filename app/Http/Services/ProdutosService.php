<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\ProdutosRepositoryInterface;
use App\Http\Interfaces\Service\AdicionaisServiceInterface;
use App\Http\Interfaces\Service\ProdutosServiceInterface;
use App\Http\Interfaces\Service\OpcoesServiceInterface;

class ProdutosService implements ProdutosServiceInterface
{
    private $repository;
    private $adicionais;
    private $opcoes;

    public function __construct
    (
        ProdutosRepositoryInterface $repository,
        AdicionaisServiceInterface $adicionais,
        OpcoesServiceInterface $opcoes
    )
    {
        $this->repository = $repository;
        $this->adicionais = $adicionais;
        $this->opcoes = $opcoes;
    }

    public function menu()
    {
        $produtos = $this->repository->produtos()->toArray();

        $produtos = array_map(function($p) {
            $p['preco'] = Helpers::formatMoney($p['preco']);
            $p['adicionais'] = $this->adicionais($p['id']);
            return $p;
        }, $produtos);

        return $produtos;
    }

    public function produtoById(int $produto)
    {
        $produto = $this->repository->produtoById($produto);

        $produto->preco = Helpers::formatMoney($produto->preco);
        $produto->adicionais = $this->adicionais($produto->id);

        return $produto;
    }

    private function adicionais($produto)
    {
        $adicionais = $this->adicionais->adicionais($produto);

        $adicionais = array_map(function($a) {
            $a->opcoes = $this->opcoes($a->id, $a->product_id);
            return $a;
        }, $adicionais);

        return $adicionais;
    }

    private function opcoes($adicional, $produto)
    {
        return $this->opcoes->opcoesByAdicional($adicional, $produto);
    }
}
