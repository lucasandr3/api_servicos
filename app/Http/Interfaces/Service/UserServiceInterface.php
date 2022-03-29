<?php


namespace App\Http\Interfaces\Service;


interface UserServiceInterface
{
    public function favoriteProfessional(object $request);

    public function getFavorites();

    public function getMyAppointments();

    public function updateProfile(object $request);

    public function updateAvatarProfile(object $request);
}
