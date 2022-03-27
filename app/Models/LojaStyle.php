<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LojaStyle extends Model
{
    protected $table = "store_style";
    protected $fillable = ['*'];
    public $timestamps = false;

//    public function loja()
//    {
//        return $this->belongsTo(Professional::class, 'id')->getResults();
//    }
}
