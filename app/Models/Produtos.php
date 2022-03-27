<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $table = "produtos";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function adicionais()
    {
        return $this->hasMany(Adicionais::class, "product_id")->getResults();
    }

    public function opcoes()
    {
        return $this->hasMany(Opcoes::class, "product_id")->getResults();
    }
}

