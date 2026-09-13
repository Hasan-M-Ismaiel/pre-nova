<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'profile_image',
        'is_available',
        'show_on_website',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'show_on_website' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
