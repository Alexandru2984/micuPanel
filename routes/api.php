<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Route;

/*
| All API endpoints require a Sanctum personal access token
| (Authorization: Bearer <token>) and are rate limited to 60 req/min/user.
| Issue a token with: php artisan micupanel:token you@example.com
*/

Route::middleware(['auth:sanctum', 'throttle:api'])->name('api.')->group(function () {
    Route::get('/user', AccountController::class);

    Route::apiResource('projects', ProjectController::class);

    Route::get('/stats', StatsController::class);
    Route::get('/tags', [CatalogController::class, 'tags']);
    Route::get('/domains', [CatalogController::class, 'domains']);
    Route::get('/services', [CatalogController::class, 'services']);

    Route::get('/export/projects.json', [ExportController::class, 'json']);
    Route::get('/export/projects.csv', [ExportController::class, 'csv']);
});
