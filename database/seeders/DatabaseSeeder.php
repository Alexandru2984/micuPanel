<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed demo data. Idempotent — safe to run repeatedly. Intended for
     * local/demo environments; in production use `php artisan micupanel:user`
     * and `php artisan micupanel:discover` instead.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@micupanel.test'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        $projects = [
            [
                'name' => 'PDF Editor',
                'slug' => 'pdf-editor',
                'description' => 'A fast PDF editor for internal use.',
                'public_url' => 'https://pdf.micutu.com',
                'stack' => 'Laravel + React',
                'status' => 'active',
                'environment' => 'production',
                'provider' => 'local VPS',
                'priority' => 'high',
            ],
            [
                'name' => 'Weather Simulation',
                'slug' => 'weather-sim',
                'description' => 'Real-time weather data simulation.',
                'stack' => 'Python + FastAPI',
                'status' => 'experimental',
                'environment' => 'demo',
                'provider' => 'local VPS',
                'priority' => 'low',
            ],
            [
                'name' => 'OpenWebUI',
                'slug' => 'open-web-ui',
                'description' => 'Local LLM interface.',
                'stack' => 'Docker',
                'status' => 'active',
                'environment' => 'production',
                'provider' => 'local VPS',
                'priority' => 'high',
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
