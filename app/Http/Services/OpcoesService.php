<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\OpcoesRepositoryInterface;
use App\Http\Interfaces\Service\OpcoesServiceInterface;

class OpcoesService implements OpcoesServiceInterface
{
    private $repository;

    public function __construct
    (
        OpcoesRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function opcoesByAdicional($adicional, $produto)
    {
        $opcoes = $this->repository->opcoesByAdicional($adicional, $produto)->toArray();

        $opcoes = array_map(function ($opcao) {
            $opcao->preco_opcao = Helpers::formatMoney($opcao->preco_opcao);
            return $opcao;
        }, $opcoes);

        return $opcoes;
    }
}
