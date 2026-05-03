<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Models\Domain;
use App\Models\Tag;
use App\Models\Service;

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'micupanel']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/projects', function () {
        return Project::all();
    });
    
    Route::get('/projects/{id}', function ($id) {
        return Project::findOrFail($id);
    });

    Route::post('/projects', function (Request $request) {
        return Project::create($request->all());
    });

    Route::put('/projects/{id}', function (Request $request, $id) {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $project;
    });

    Route::delete('/projects/{id}', function ($id) {
        Project::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    });

    Route::get('/tags', function () {
        return Tag::all();
    });

    Route::get('/domains', function () {
        return Domain::all();
    });

    Route::get('/services', function () {
        return Service::all();
    });

    Route::get('/stats', function () {
        return response()->json([
            'projects' => Project::count(),
            'domains' => Domain::count(),
            'services' => Service::count(),
        ]);
    });

    Route::get('/export/projects.json', function () {
        return response()->json(Project::with(['domains', 'repositories', 'services', 'notes', 'quickLinks'])->get());
    });

    Route::get('/export/projects.csv', function () {
        $projects = Project::all();
        $csvData = "id,name,slug,status,environment\n";
        foreach ($projects as $project) {
            $csvData .= "{$project->id},{$project->name},{$project->slug},{$project->status},{$project->environment}\n";
        }
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="projects.csv"');
    });
});
