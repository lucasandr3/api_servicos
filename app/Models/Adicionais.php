<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adicionais extends Model
{
    protected $table = "produtos_adicionais";
    protected $fillable = ['*'];
    public $timestamps = false;
}

