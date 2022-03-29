<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\ProfessionalRepositoryInterface;
use App\Http\Interfaces\Repository\UserRepositoryInterface;
use App\Http\Interfaces\Service\UserServiceInterface;

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
}
