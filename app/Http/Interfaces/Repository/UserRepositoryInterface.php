<?php


namespace App\Http\Interfaces\Repository;


interface UserRepositoryInterface
{
    public function favoriteProfessional(int $user, int $professional);

    public function getMyFavorites(int $user);
}
