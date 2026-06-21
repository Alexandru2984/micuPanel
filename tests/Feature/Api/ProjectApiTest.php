<?php

namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_unauthorized(): void
    {
        $this->getJson('/api/projects')->assertUnauthorized();
        $this->getJson('/api/stats')->assertUnauthorized();
    }

    public function test_token_user_can_list_projects(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Project::factory()->count(3)->create();

        $this->getJson('/api/projects')
            ->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_a_project(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/projects', [
            'name' => 'Demo Project',
            'slug' => 'demo-project',
            'status' => 'active',
            'local_port' => 8080,
        ])
            ->assertCreated()
            ->assertJsonPath('data.slug', 'demo-project');

        $this->assertDatabaseHas('projects', ['slug' => 'demo-project']);
    }

    public function test_create_is_validated(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/projects', [
            'name' => '',
            'slug' => 'not a valid slug!',
            'status' => 'bogus',
            'local_port' => 999999,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'slug', 'status', 'local_port']);
    }

    public function test_can_show_update_and_delete_a_project(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $project = Project::factory()->create();

        $this->getJson("/api/projects/{$project->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $project->id);

        $this->putJson("/api/projects/{$project->id}", ['name' => 'Renamed'])
            ->assertOk()
            ->assertJsonPath('data.name', 'Renamed');

        $this->deleteJson("/api/projects/{$project->id}")->assertNoContent();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_csv_export_neutralises_formula_injection(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Project::factory()->create(['name' => '=cmd|calc', 'slug' => 'evil-one']);

        $response = $this->get('/api/export/projects.csv');

        $response->assertOk();
        // The leading '=' must be prefixed with a single quote so spreadsheets
        // treat it as text instead of a formula.
        $this->assertStringContainsString("'=cmd|calc", $response->streamedContent());
    }

    public function test_stats_endpoint_returns_counts(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Project::factory()->count(2)->create();

        $this->getJson('/api/stats')
            ->assertOk()
            ->assertJsonPath('projects', 2);
    }
}
