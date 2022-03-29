<?php


namespace App\Http\Interfaces\Service;


interface UserServiceInterface
{
    public function favoriteProfessional(object $request);

    public function getFavorites();
}
