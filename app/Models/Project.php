<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'client_name',
        'industry',
        'description',
        'problem',
        'solution',
        'technologies',
        'results',
        'status',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'project_service'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Contributors / Specialists
    |--------------------------------------------------------------------------
    */

    public function contributors()
    {
        return $this->belongsToMany(
            User::class,
            'project_contributors',
            'project_id',
            'specialist_id'
        )
            ->withPivot([
                'role_id',
                'contribution',
            ])
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Proposals
    |--------------------------------------------------------------------------
    */

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isOnHold(): bool
    {
        return $this->status === 'on_hold';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    /*
    |--------------------------------------------------------------------------
    | Media / Gallery
    |--------------------------------------------------------------------------
    */

    public function media()
    {
        return $this->hasMany(ProjectMedia::class)
            ->orderBy('sort_order');
    }
}
