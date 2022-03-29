<?php


namespace App\Http\Interfaces\Repository;


interface ProfessionalRepositoryInterface
{
    public function getProfessionals($latitude, $longitude, $offset);

    public function getProfessionalByID(int $professional);

    public function getAppointmentsByProfessional(int $profesisonal, array $filter);

    public function isFavorite(int $user, int $professional);

    public function unFavorite(int $user, int $professional);

    public function isExistsProfessional(int $service, int $professional);

    public function professionalExists(int $professional);

    public function getAppointmentsByProfessionalCount($professional, $apDate);

    public function getWeekDayByProfessional($professional, $weekDay);

    public function saveAppointments($newApp);
}
