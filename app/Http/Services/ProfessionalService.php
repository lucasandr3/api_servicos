<?php


namespace App\Http\Services;


use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Http\Interfaces\Service\ProfessionalServiceInterface;

class ProfessionalService implements ProfessionalServiceInterface
{
    private $repository;

    public function __construct(ProfessionalRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function informacaoLoja()
    {
        return $this->repository->getInfo();
    }

    public function informacaoLojaDados()
    {
        $loja = $this->repository->getInfo();

        $dados = [
            'nome' => $loja,
            'informacoes' => $loja->informacoes(),
            'tema' => $loja->tema()
        ];

        return $dados;
    }
}
