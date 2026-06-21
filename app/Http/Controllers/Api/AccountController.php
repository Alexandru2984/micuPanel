<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Return the currently authenticated user (password/token fields are
     * already hidden by the User model).
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
