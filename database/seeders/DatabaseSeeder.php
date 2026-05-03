<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'name' => 'PDF Editor',
            'slug' => 'pdf-editor',
            'description' => 'A fast PDF editor for internal use.',
            'public_url' => 'https://pdf.micutu.com',
            'stack' => 'Laravel + React',
            'status' => 'active',
            'environment' => 'production',
            'provider' => 'local VPS',
            'priority' => 'high'
        ]);

        Project::create([
            'name' => 'Weather Simulation',
            'slug' => 'weather-sim',
            'description' => 'Real-time weather data simulation.',
            'stack' => 'Python + FastAPI',
            'status' => 'experimental',
            'environment' => 'demo',
            'provider' => 'local VPS',
            'priority' => 'low'
        ]);
        
        Project::create([
            'name' => 'OpenWebUI',
            'slug' => 'open-web-ui',
            'description' => 'Local LLM interface.',
            'stack' => 'Docker',
            'status' => 'active',
            'environment' => 'production',
            'provider' => 'local VPS',
            'priority' => 'high'
        ]);
    }
}
