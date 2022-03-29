<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professional extends Model
{
    protected $table = "professionals";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function getAvatarAttribute($value): string
    {
        return url("media/avatars/{$value}");
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProfessionalPhotos::class, 'professional_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(ProfessionalServices::class, 'professional_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(ProfessionalTestimonials::class, 'professional_id');
    }

    public function availability(): HasMany
    {
        return $this->hasMany(ProfessionalAvailability::class, 'professional_id');
    }
}

