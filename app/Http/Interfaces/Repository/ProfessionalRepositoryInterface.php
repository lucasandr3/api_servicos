<?php


namespace App\Http\Interfaces\Repository;


interface ProfessionalRepositoryInterface
{
    public function getProfessionals($latitude, $longitude, $offset);

    public function getProfessionalByID(int $professional);

    public function getAppointmentsByProfessional(int $profesisonal, array $filter);

    public function isFavorite(int $user, int $professional);
}
