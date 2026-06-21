<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repository extends Model
{
    public const PROVIDERS = ['GitHub', 'GitLab', 'Bitbucket', 'local', 'other'];

    protected $fillable = [
        'project_id',
        'repo_url',
        'provider',
        'default_branch',
        'notes',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
