<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repository\CategoriaRepositoryInterface;
use App\Models\Categoria;

class CategoriaRepository implements CategoriaRepositoryInterface
{
    public function categorias()
    {
        return Categoria::all();
    }
}
