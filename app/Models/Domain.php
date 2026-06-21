<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    public const TYPES = ['primary', 'alias', 'api', 'frontend', 'admin'];

    protected $fillable = [
        'project_id',
        'domain',
        'type',
        'cloudflare_enabled',
        'ssl_enabled',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'cloudflare_enabled' => 'boolean',
            'ssl_enabled' => 'boolean',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
