<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Project::class);

        $projects = Project::orderBy('name')->get();

        return view('projects.index', compact('projects'));
    }
}
