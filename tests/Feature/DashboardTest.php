<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/docs')->assertRedirect('/login');
    }

    public function test_authenticated_user_sees_dashboard_with_stats(): void
    {
        $user = User::factory()->create();
        Project::factory()->count(2)->create(['status' => 'active']);
        Project::factory()->create(['status' => 'broken']);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertViewIs('dashboard')
            ->assertViewHas('stats')
            ->assertViewHas('recent_projects');
    }

    public function test_authenticated_user_sees_projects_index(): void
    {
        $user = User::factory()->create();
        Project::factory()->count(3)->create();

        $this->actingAs($user)
            ->get('/projects')
            ->assertOk()
            ->assertViewIs('projects.index')
            ->assertViewHas('projects');
    }
}
