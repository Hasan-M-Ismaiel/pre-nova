<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'image',
        'is_active',
        'show_on_website',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_website' => 'boolean',
    ];

    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            'project_service'
        )->withTimestamps();
    }

    protected static function booted(): void
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }
    
}
