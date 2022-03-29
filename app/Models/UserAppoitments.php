<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class UserAppoitments extends Model
{
    protected $table = "userappointments";
    protected $fillable = ['*'];
    public $timestamps = false;
}

