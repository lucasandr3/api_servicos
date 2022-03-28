<?php


namespace App\Http\Interfaces\Repository;


interface ProfessionalRepositoryInterface
{
    public function getProfessionals($latitude, $longitude, $offset);
}
