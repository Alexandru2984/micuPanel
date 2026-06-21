<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement(Project::STATUSES),
            'environment' => fake()->randomElement(Project::ENVIRONMENTS),
            'priority' => fake()->randomElement(Project::PRIORITIES),
            'public_url' => fake()->url(),
            'stack' => fake()->randomElement(['Laravel', 'Node.js/JS', 'Python', 'Go']),
            'local_port' => fake()->numberBetween(3000, 9000),
        ];
    }
}
