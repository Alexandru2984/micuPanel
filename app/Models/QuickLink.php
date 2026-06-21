<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickLink extends Model
{
    public const TYPES = ['public', 'repo', 'docs', 'grafana', 'sentry', 'uptime', 'admin', 'other'];

    protected $fillable = [
        'project_id',
        'label',
        'url',
        'type',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
