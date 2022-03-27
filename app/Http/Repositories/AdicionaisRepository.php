<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\AdicionaisRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AdicionaisRepository implements AdicionaisRepositoryInterface
{
    public function adicionais($produto)
    {
        return DB::table('produtos_adicionais')->where('product_id', $produto)->get();
    }
}
