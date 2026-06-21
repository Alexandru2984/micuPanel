<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Project;
use App\Models\Repository;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'projects' => Project::count(),
            'domains' => Domain::count(),
            'repositories' => Repository::count(),
            'services' => Service::count(),
            'tags' => Tag::count(),
        ]);
    }
}
