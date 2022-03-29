<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class ProfessionalServices extends Model
{
    protected $table = "professionalservices";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function getPriceAttribute($value): string
    {
        return Helpers::formatMoney($value);
    }
}

