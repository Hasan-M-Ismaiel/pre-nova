<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'client_name',
        'client_email',
        'client_phone',
        'description',
        'scope',
        'terms',
        'amount',
        'status',
        'token',
        'approved_at',
        'sent_at',
        'project_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($proposal) {
            if (!$proposal->token) {
                $proposal->token = Str::random(64);
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
