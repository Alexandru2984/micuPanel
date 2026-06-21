<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    public const TYPES = ['systemd', 'docker', 'nginx', 'php-fpm', 'other'];

    protected $fillable = [
        'project_id',
        'service_name',
        'service_type',
        'local_port',
        'config_path',
        'log_hint',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'local_port' => 'integer',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
