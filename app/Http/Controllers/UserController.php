<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\Service\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct
    (
        UserServiceInterface $service
    )
    {
        $this->service = $service;
    }

    public function read()
    {
        $user = [
            'id' => auth()->user()->getAuthIdentifier(),
            'name' => auth()->user()['name'],
            'avatar' => url('media/avatars/'.auth()->user()['avatar']),
            'email' => auth()->user()['email']
        ];

        return ['error' => '', 'data' => $user];
    }

    public function addFavorite(Request $request)
    {
        return $this->service->favoriteProfessional($request);
    }

    public function getFavorites()
    {
        return $this->service->getFavorites();
    }

    public function getAppointments()
    {
        return $this->service->getMyAppointments();
    }

    public function update(Request $request)
    {
        return $this->service->updateProfile($request);
    }

    public function updateAvatar(Request $request)
    {
        return $this->service->updateAvatarProfile($request);
    }
}
