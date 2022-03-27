<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LojaInfo extends Model
{
    protected $table = "store_info";
    protected $fillable = ['*'];
    public $timestamps = false;
}

