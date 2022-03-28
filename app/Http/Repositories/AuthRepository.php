<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryInterface
{

    public function registerUser(object $request)
    {
        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($request->input('password'));

            $user->save();
            return ['error' => '','user' => $user, 'message' => 'CREATED', 'status' => 201];

        } catch (\Exception $e) {
            return ['message' => 'Erro ao cadastrar usuário!', 'status' => 409];
        }
    }

    public function loginUser(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return ['error' => 'Dados Incorretos.'];
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => \auth()->user()
        ], 200);
    }

    public function refresh()
    {
        $token = \auth()->refresh();
        return $this->respondWithToken($token);
    }

    private function dadosUsuario()
    {
        $usuario = [
            'id' => \auth()->user()['id_user'],
            'full_name' => \auth()->user()['full_name'],
            'first_name' => \auth()->user()['first_name'],
            'last_name' => \auth()->user()['last_name'],
            'email' => \auth()->user()['email']
        ];

        $enderecos = DB::table('clientes_endereco as ce')
            ->select(
                'ce.id',
                'ce.cep',
                'ce.rua',
                'ce.numero',
                'ce.bairro',
                'ce.estado',
                'ce.cidade',
                'ce.referencia'
            )
            ->where('ce.user_id', \auth()->user()['id_user'])
            ->get();

        return ['usuario' => $usuario, 'enderecos' => $enderecos];
    }
}
