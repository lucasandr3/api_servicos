<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserAppoitments;
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
            return response()->json(['error' => '', 'message' => 'Profissional Favoritado com sucesso!', 'have' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao favoritar profissional!', 'have' => false], 409);
        }
    }

    public function getMyFavorites(int $user)
    {
        return UserFavorite::where('user_id', $user)->get();
    }

    public function getMyAppointments(int $user)
    {
        return UserAppoitments::where('user_id', $user)->orderBy('ap_datetime', 'DESC')->get();
    }

    public function updateMe(object $data, int $me, $update)
    {
        if ($update) {

            try {

                $user = User::find($me);

                if ($data->name) {
                    $user->name = $data->name;
                }

                if ($data->email) {
                    $user->email = $data->email;
                }

                if ($data->password) {
                    $user->password = app('hash')->make($data->password);
                }

                $user->save();
                return response()->json(['error' => '', 'message' => 'Perfil atualizado com sucesso.'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Algo deu errado, tente novamente.'], 409);
            }

        } else {
            return response()->json(['error' => ''], 200);
        }
    }

    public function updateAvatar(string $nameAvatar, int $me)
    {
        try {

            $user = User::find($me);
            $user->avatar = $nameAvatar;
            $user->save();
            return response()->json(['error' => '', 'message' => 'Avatar atualizado com sucesso.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Algo deu errado, tente novamente.'], 409);
        }
    }
}
