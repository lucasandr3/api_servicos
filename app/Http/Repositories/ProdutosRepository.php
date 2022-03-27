<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\ProdutosRepositoryInterface;
use App\Models\Produtos;
use Illuminate\Support\Facades\DB;

class ProdutosRepository implements ProdutosRepositoryInterface
{

    public function produtos()
    {
        return Produtos::all();
    }

    public function adicionais($produto)
    {
        return DB::table('produtos_adicionais')->where('product_id', $produto)->get();
    }

    public function produtoById(int $produto)
    {
        return Produtos::find($produto);
    }
}
