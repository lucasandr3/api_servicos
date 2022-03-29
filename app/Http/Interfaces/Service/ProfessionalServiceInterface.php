<?php


namespace App\Http\Interfaces\Service;


interface ProfessionalServiceInterface
{
    public function allProfessionals($request);

    public function getProfessional(int $professional);
}
