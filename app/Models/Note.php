<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    public const TYPES = ['todo', 'bug', 'idea', 'deploy', 'security', 'maintenance', 'general'];

    protected $fillable = [
        'project_id',
        'title',
        'body',
        'type',
        'pinned',
    ];

    protected function casts(): array
    {
        return [
            'pinned' => 'boolean',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
