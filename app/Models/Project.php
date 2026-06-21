<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public const STATUSES = ['active', 'paused', 'broken', 'archived', 'experimental'];

    public const ENVIRONMENTS = ['production', 'staging', 'demo', 'local'];

    public const PRIORITIES = ['low', 'medium', 'high'];

    /**
     * Mass-assignable attributes. Explicitly listed (never `$guarded = []`)
     * so untrusted request payloads cannot set unexpected columns.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'public_url',
        'primary_domain',
        'repository_url',
        'local_path',
        'stack',
        'status',
        'environment',
        'provider',
        'local_port',
        'systemd_service_name',
        'nginx_config_path',
        'database_type',
        'notes',
        'priority',
        'last_deployed_at',
        'last_checked_at',
    ];

    protected function casts(): array
    {
        return [
            'local_port' => 'integer',
            'last_deployed_at' => 'datetime',
            'last_checked_at' => 'datetime',
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function quickLinks(): HasMany
    {
        return $this->hasMany(QuickLink::class);
    }
}
