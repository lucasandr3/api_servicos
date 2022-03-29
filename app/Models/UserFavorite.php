<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    protected $table = "userfavorites";
    protected $fillable = ['*'];
    public $timestamps = false;
}

