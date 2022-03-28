<?php

namespace App\Http\Services;

use App\Helpers\Helpers;
use App\Http\Interfaces\Repository\AuthRepositoryInterface;
use App\Http\Interfaces\Service\AuthServiceInterface;
use Illuminate\Support\Facades\Validator;

class AuthService implements AuthServiceInterface
{
    private $repository;

    public function __construct
    (
        AuthRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function register(object $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if (!$validator->fails()) {

            $create = $this->repository->registerUser($request);

            if($create['status'] == 201) {
                return ['error' => '', 'data' => $this->login($request)];
            } else {
                return $create;
            }

        } else {
            return response()->json(['message' => $validator->errors()->first()]);
        }
    }

    public function login(object $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$validator->fails()) {

            $credentials = $request->only(['email', 'password']);
            return response()->json($this->repository->loginUser($credentials), 201);

        } else {
            return response()->json(['message' => $validator->errors()->first()]);
        }
    }

    public function refresh()
    {
        return $this->repository->refresh();
    }
}
