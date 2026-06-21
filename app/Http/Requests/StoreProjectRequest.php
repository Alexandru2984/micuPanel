<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Project::class) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:projects,slug'],
            'description' => ['nullable', 'string'],
            'public_url' => ['nullable', 'url', 'max:255'],
            'primary_domain' => ['nullable', 'string', 'max:255'],
            'repository_url' => ['nullable', 'string', 'max:255'],
            'local_path' => ['nullable', 'string', 'max:255'],
            'stack' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(Project::STATUSES)],
            'environment' => ['nullable', Rule::in(Project::ENVIRONMENTS)],
            'provider' => ['nullable', 'string', 'max:255'],
            'local_port' => ['nullable', 'integer', 'between:1,65535'],
            'systemd_service_name' => ['nullable', 'string', 'max:255'],
            'nginx_config_path' => ['nullable', 'string', 'max:255'],
            'database_type' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'priority' => ['nullable', Rule::in(Project::PRIORITIES)],
            'last_deployed_at' => ['nullable', 'date'],
            'last_checked_at' => ['nullable', 'date'],
        ];
    }
}
