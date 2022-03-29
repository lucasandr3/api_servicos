<?php


namespace App\Http\Interfaces\Repository;


interface UserRepositoryInterface
{
    public function favoriteProfessional(int $user, int $professional);

    public function getMyFavorites(int $user);

    public function getMyAppointments(int $user);

    public function updateMe(object $data, int $me, $update);

    public function updateAvatar(string $nameAvatar, int $me);
}
