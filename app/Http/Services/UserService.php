<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Http\Interfaces\Repository\UserRepositoryInterface;
use App\Http\Interfaces\Service\UserServiceInterface;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserService implements UserServiceInterface
{
    private $repository;
    private $professionalRepository;

    public function __construct
    (
        UserRepositoryInterface $repository,
        ProfessionalRepositoryInterface $professionalRepository
    )
    {
        $this->repository = $repository;
        $this->professionalRepository = $professionalRepository;
    }

    public function favoriteProfessional(object $request)
    {
        $professional = $request->input('professional');

        if(!$professional) {
            return response()->json(['error' => 'Profissional não informado']);
        }

        $professionalExists = $this->professionalRepository->professionalExists($professional);

        if(!$professionalExists) {
            return response()->json(['error' => 'Profissional não existe ou não informado']);
        }

        $hasFavorite = $this->professionalRepository->isFavorite(auth()->user()->getAuthIdentifier(), $professional);

        if($hasFavorite === 0) {
            return $this->repository->favoriteProfessional(auth()->user()->getAuthIdentifier(), $professional);
        } else {
            return $this->professionalRepository->unFavorite(auth()->user()->getAuthIdentifier(), $professional);
        }
    }

    public function getFavorites()
    {
        $favorites = $this->repository->getMyFavorites(auth()->user()->getAuthIdentifier())->toArray();
        $myFavorites = [];

        foreach ($favorites as $fav) {
            $myFavorites[] = $this->professionalRepository->getProfessionalByID($fav['professional_id'])->toArray();
        }

        return response()->json(['error' => '', 'list' => $myFavorites]);
    }

    public function getMyAppointments()
    {
        $appointments = $this->repository->getMyAppointments(auth()->user()->getAuthIdentifier());

        if(!$appointments) {
            return response()->json(['error' => 'Você não possui agendamentos.']);
        }

        $myAppointments = [];

        foreach ($appointments as $item) {
            $professional = $this->professionalRepository->getProfessionalByID($item->professional_id);
            $service = $this->professionalRepository->getServiceByID($item->id_service);

            $myAppointments[] = [
                'id' => $item->id,
                'datetime' => $item->ap_datetime,
                'professional' => $professional,
                'service' => $service
            ];
        }

        return response()->json(['error' => '', 'list' => $myAppointments]);
    }

    public function updateProfile(object $request)
    {
        $update = false;

        $rules = [
            'name' => 'min:2',
            'email' => 'email|unique:users',
            'password' => 'same:password_confirm',
            'password_confirm' => 'same:password'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirm = $request->input('password_confirm');

        $data = new \stdClass();
        $data->name = $name;
        $data->email = $email;
        $data->password = $password;

        if($name) {
            $update = true;
        }

        if($email) {
            $update = true;
        }

        if($password) {
            $update = true;
        }

        return $this->repository->updateMe($data, auth()->user()->getAuthIdentifier(), $update);
    }

    public function updateAvatarProfile(object $request)
    {
        $rules = [
            'avatar' => 'required|image|mimes:png,jpg,jpeg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $avatar = $request->file('avatar');
        $directory = app()->basePath().'/public/media/avatars';
        $avatarName = md5(time().rand(0,9999)).'.jpg';

        $img = Image::make($avatar->getRealPath());
        $img->fit(300,300)->save($directory.'/'.$avatarName);

        return $this->repository->updateAvatar($avatarName, auth()->user()->getAuthIdentifier());
    }
}
