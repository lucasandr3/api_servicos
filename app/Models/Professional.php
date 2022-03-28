<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = "professionals";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function getAvatarAttribute($value): string
    {
        return url("media/avatars/{$value}");
    }
}

