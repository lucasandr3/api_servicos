<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\AdicionaisRepositoryInterface;
use App\Http\Interfaces\Service\AdicionaisServiceInterface;

class AdicionaisService implements AdicionaisServiceInterface
{
    private $repository;

    public function __construct
    (
        AdicionaisRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function adicionais($produto)
    {
        return $this->repository->adicionais($produto)->toArray();
    }
}
