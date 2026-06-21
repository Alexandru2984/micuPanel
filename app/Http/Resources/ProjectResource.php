<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'environment' => $this->environment,
            'priority' => $this->priority,
            'public_url' => $this->public_url,
            'primary_domain' => $this->primary_domain,
            'repository_url' => $this->repository_url,
            'local_path' => $this->local_path,
            'stack' => $this->stack,
            'provider' => $this->provider,
            'local_port' => $this->local_port,
            'systemd_service_name' => $this->systemd_service_name,
            'nginx_config_path' => $this->nginx_config_path,
            'database_type' => $this->database_type,
            'notes' => $this->notes,
            'last_deployed_at' => optional($this->last_deployed_at)->toIso8601String(),
            'last_checked_at' => optional($this->last_checked_at)->toIso8601String(),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
            'tags' => $this->whenLoaded('tags'),
            'domains' => $this->whenLoaded('domains'),
            'repositories' => $this->whenLoaded('repositories'),
            'services' => $this->whenLoaded('services'),
            'project_notes' => $this->whenLoaded('projectNotes'),
            'quick_links' => $this->whenLoaded('quickLinks'),
        ];
    }
}
