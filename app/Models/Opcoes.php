<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcoes extends Model
{
    protected $table = "produtos_opcoes";
    protected $fillable = ['*'];
    public $timestamps = false;
}

