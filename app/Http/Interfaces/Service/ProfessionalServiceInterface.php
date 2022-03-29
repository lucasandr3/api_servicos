<?php


namespace App\Http\Interfaces\Service;


interface ProfessionalServiceInterface
{
    public function allProfessionals($request);

    public function getProfessional(int $professional);

    public function newAppointment(int $professional, object $request);

    public function searchProfessional(object $request);
}
