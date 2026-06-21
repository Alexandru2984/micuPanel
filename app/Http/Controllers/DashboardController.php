<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Project;
use App\Models\Repository;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $byStatus = Project::query()
            ->groupBy('status')
            ->selectRaw('status, count(*) as total')
            ->pluck('total', 'status');

        $stats = [
            'total_projects' => (int) $byStatus->sum(),
            'active_projects' => (int) ($byStatus['active'] ?? 0),
            'broken_projects' => (int) ($byStatus['broken'] ?? 0),
            'experimental_projects' => (int) ($byStatus['experimental'] ?? 0),
            'archived_projects' => (int) ($byStatus['archived'] ?? 0),
            'total_domains' => Domain::count(),
            'total_repositories' => Repository::count(),
            'total_services' => Service::where('service_type', 'systemd')->count(),
        ];

        $recentProjects = Project::latest('updated_at')->take(5)->get();

        return view('dashboard', [
            'stats' => $stats,
            'recent_projects' => $recentProjects,
        ]);
    }
}
