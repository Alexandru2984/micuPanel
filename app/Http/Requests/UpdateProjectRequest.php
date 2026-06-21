<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('project')) ?? false;
    }

    /**
     * Partial updates are allowed: each field is validated only when present.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'sometimes', 'required', 'string', 'max:255', 'alpha_dash',
                Rule::unique('projects', 'slug')->ignore($this->route('project')),
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'public_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'primary_domain' => ['sometimes', 'nullable', 'string', 'max:255'],
            'repository_url' => ['sometimes', 'nullable', 'string', 'max:255'],
            'local_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'stack' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'required', Rule::in(Project::STATUSES)],
            'environment' => ['sometimes', 'required', Rule::in(Project::ENVIRONMENTS)],
            'provider' => ['sometimes', 'nullable', 'string', 'max:255'],
            'local_port' => ['sometimes', 'nullable', 'integer', 'between:1,65535'],
            'systemd_service_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'nginx_config_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'database_type' => ['sometimes', 'nullable', 'string', 'max:255'],
            'notes' => ['sometimes', 'nullable', 'string'],
            'priority' => ['sometimes', 'required', Rule::in(Project::PRIORITIES)],
            'last_deployed_at' => ['sometimes', 'nullable', 'date'],
            'last_checked_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
