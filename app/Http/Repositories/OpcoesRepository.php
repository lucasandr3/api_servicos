<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\AdicionaisRepositoryInterface;
use App\Http\Interfaces\Repository\OpcoesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OpcoesRepository implements OpcoesRepositoryInterface
{
    public function opcoesByAdicional($adicional, $produto)
    {
        return DB::table('produtos_opcoes')
            ->where('adicional_id', $adicional)
            ->where('product_id', $produto)
            ->get();
    }
}
