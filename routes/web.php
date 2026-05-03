<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Models\Domain;
use App\Models\Repository;
use App\Models\Service;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'micupanel'
    ]);
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $stats = [
        'total_projects' => Project::count(),
        'active_projects' => Project::where('status', 'active')->count(),
        'broken_projects' => Project::where('status', 'broken')->count(),
        'experimental_projects' => Project::where('status', 'experimental')->count(),
        'archived_projects' => Project::where('status', 'archived')->count(),
        'total_domains' => Domain::count(),
        'total_repositories' => Repository::count(),
        'total_services' => Service::where('service_type', 'systemd')->count(),
    ];
    $recent_projects = Project::orderBy('updated_at', 'desc')->take(5)->get();
    
    return view('dashboard', compact('stats', 'recent_projects'));
})->middleware(['auth'])->name('dashboard');

Route::get('/docs', function () {
    return view('docs');
})->middleware(['auth'])->name('docs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
