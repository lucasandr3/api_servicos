<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = "store";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function informacoes()
    {
        return $this->hasOne(LojaInfo::class, "id_store")->getResults();
    }

    public function tema()
    {
        return $this->hasOne(LojaStyle::class, "id_store")->getResults();
    }
}

