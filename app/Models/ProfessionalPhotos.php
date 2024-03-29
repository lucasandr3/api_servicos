<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalPhotos extends Model
{
    protected $table = "professionalphotos";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function getUrlAttribute($value): string
    {
        return url("media/avatars/professionals/{$value}");
    }
}

