<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Models\Professional;
use App\Models\ProfessionalAvailability;
use App\Models\ProfessionalServices;
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

    public function unFavorite(int $user, int $professional)
    {
        try {
            UserFavorite::where('user_id', $user)->where('professional_id', $professional)->first()->delete();
            return response()->json(['error' => '', 'have' => false]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'algo deu errado, tente novamente', 'have' => true]);
        }
    }

    public function isExistsProfessional(int $service, int $professional)
    {
        return ProfessionalServices::where('id', $service)
            ->where('professional_id', $professional)
            ->first();
    }

    public function professionalExists(int $professional)
    {
        return Professional::find($professional);
    }

    public function getAppointmentsByProfessionalCount($professional, $apDate)
    {
        return UserAppoitments::where('professional_id', $professional)
            ->where('ap_datetime', $apDate)
            ->count();
    }

    public function getWeekDayByProfessional($professional, $weekDay)
    {
        return ProfessionalAvailability::where('professional_id', $professional)
            ->where('weekday', $weekDay)
            ->first();
    }

    public function saveAppointments($newApp)
    {
        try {
            $newApp->save();
            return response()->json(['error' => '','message' => 'Agendamento feito com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar usuário!'], 409);
        }
    }
}
