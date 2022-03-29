<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Models\Professional;
use App\Models\UserAppoitments;
use App\Models\UserFavorite;

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

    public function getProfessionalByID(int $professional)
    {
        return Professional::find($professional);
    }

    public function getAppointmentsByProfessional(int $profesisonal, array $filter)
    {
        return UserAppoitments::where('professional_id', $profesisonal)
            ->whereBetween('ap_datetime', $filter)
            ->get();
    }

    public function isFavorite(int $user, int $professional)
    {
        return UserFavorite::where('user_id', $user)->where('professional_id', $professional)->count();
    }
}
