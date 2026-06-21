<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function tags(): JsonResponse
    {
        return response()->json(Tag::orderBy('name')->get());
    }

    public function domains(): JsonResponse
    {
        return response()->json(Domain::with('project:id,name,slug')->get());
    }

    public function services(): JsonResponse
    {
        return response()->json(Service::with('project:id,name,slug')->get());
    }
}
