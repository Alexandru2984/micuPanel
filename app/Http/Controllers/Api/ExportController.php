<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function json(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Project::class);

        return ProjectResource::collection(
            Project::with([
                'tags', 'domains', 'repositories', 'services', 'projectNotes', 'quickLinks',
            ])->get()
        );
    }

    public function csv(): StreamedResponse
    {
        $this->authorize('viewAny', Project::class);

        $columns = ['id', 'name', 'slug', 'status', 'environment'];

        return response()->streamDownload(function () use ($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);

            Project::orderBy('id')->chunk(200, function ($projects) use ($out) {
                foreach ($projects as $project) {
                    fputcsv($out, [
                        $project->id,
                        $this->csvSafe($project->name),
                        $this->csvSafe($project->slug),
                        $this->csvSafe($project->status),
                        $this->csvSafe($project->environment),
                    ]);
                }
            });

            fclose($out);
        }, 'projects.csv', ['Content-Type' => 'text/csv']);
    }

    /**
     * Neutralise CSV / spreadsheet formula injection. fputcsv() already
     * escapes delimiters and quotes; this prefixes values beginning with a
     * formula trigger so they are treated as inert text by spreadsheet apps.
     */
    private function csvSafe(?string $value): string
    {
        $value = (string) $value;

        if ($value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'".$value;
        }

        return $value;
    }
}
