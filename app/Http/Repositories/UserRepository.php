<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserFavorite;

class UserRepository implements UserRepositoryInterface
{
    public function favoriteProfessional(int $user, int $professional)
    {
        try {
            $newFav = new UserFavorite();
            $newFav->user_id = $user;
            $newFav->professional_id = $professional;
            $newFav->save();
            return response()->json(['error' => '','message' => 'Profissional Favoritado com sucesso!', 'have' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao favoritar profissional!', 'have' => false], 409);
        }
    }

    public function getMyFavorites(int $user)
    {
        return UserFavorite::where('user_id', $user)->get();
    }
}
