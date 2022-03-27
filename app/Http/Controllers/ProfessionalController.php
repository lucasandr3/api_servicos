<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\ProfessionalServiceInterface;

class ProfessionalController extends Controller
{
    private $service;

    public function __construct
    (
        ProfessionalServiceInterface $service
    )
    {
        $this->service = $service;
    }

    public function nome()
    {
        return $this->service->informacaoLoja();
    }

    public function informacoes()
    {
        return $this->service->informacaoLoja()->informacoes();
    }

    public function tema()
    {
        return $this->service->informacaoLoja()->tema();
    }

    public function dados()
    {
        return $this->service->informacaoLojaDados();
    }
}
