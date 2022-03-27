<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Models\Professional;

class ProfessionalRepository implements ProfessionalRepositoryInterface
{
    public function getInfo()
    {
        return Professional::first();
    }
}
