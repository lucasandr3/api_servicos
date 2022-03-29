<?php

namespace App\Http\Services;


use App\Http\Interfaces\Repository\ProductsProfessionalRepositoryInterface;

class ProductsProfessionalService implements ProductsProfessionalRepositoryInterface
{
    private $repository;

    public function __construct
    (
        ProductsProfessionalRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }
}
