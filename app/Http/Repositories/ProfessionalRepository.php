<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Models\Professional;

class ProfessionalRepository implements ProfessionalRepositoryInterface
{
    public function getProfessionals($latitude, $longitude, $offset)
    {
        return Professional::select(Professional::raw(
            '*, SQRT(
                POW(69.1 * (latitude - '.$latitude.'), 2) +
                POW(69.1 * ('.$longitude.' - longitude) * COS(latitude / 57.3), 2)) AS distance
            '
        ))
            ->havingRaw('distance < ?', [10])
            ->orderBy('distance', 'ASC')
            ->offset($offset)
            ->limit(5)
            ->get();
    }
}
