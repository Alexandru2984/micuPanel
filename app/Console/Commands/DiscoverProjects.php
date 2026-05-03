<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Repository;
use Illuminate\Support\Str;

class DiscoverProjects extends Command
{
    protected $signature = 'micupanel:discover {--dir=/home/micu : The base directory to scan}';
    protected $description = 'Auto-discover projects in a directory and add them to MicuPanel';

    public function handle()
    {
        $baseDir = $this->option('dir');
        $this->info("Scanning $baseDir for projects...");

        if (!is_dir($baseDir)) {
            $this->error("Directory $baseDir does not exist.");
            return;
        }

        $dirs = array_filter(glob($baseDir . '/*'), 'is_dir');
        $added = 0;
        $updated = 0;

        foreach ($dirs as $dir) {
            $folderName = basename($dir);

            // Skip hidden, cache or the panel itself
            if (str_starts_with($folderName, '.') || $folderName === 'micuPanel' || $folderName === '__pycache__' || $folderName === 'apps' || $folderName === 'assets' || $folderName === 'snap' || $folderName === 'vps' || $folderName === 'vazute') {
                continue;
            }

            $slug = Str::slug($folderName);
            $name = str_replace(['_', '-'], ' ', $folderName);
            $name = ucwords($name);

            $stack = $this->detectStack($dir);
            $repoUrl = $this->detectGitRepo($dir);

            $project = Project::where('slug', $slug)->orWhere('local_path', $dir)->first();

            if (!$project) {
                $project = Project::create([
                    'name' => $name,
                    'slug' => $slug,
                    'local_path' => $dir,
                    'stack' => $stack,
                    'status' => 'experimental',
                    'environment' => 'local',
                    'priority' => 'medium',
                ]);
                $added++;
                $this->line("Added: $name ($stack)");
            } else {
                $project->update([
                    'local_path' => $dir,
                    'stack' => $stack ?: $project->stack,
                ]);
                $updated++;
                $this->line("Updated: $name");
            }

            if ($repoUrl) {
                $provider = 'other';
                if (str_contains($repoUrl, 'github.com')) $provider = 'GitHub';
                elseif (str_contains($repoUrl, 'gitlab.com')) $provider = 'GitLab';
                elseif (str_contains($repoUrl, 'bitbucket.org')) $provider = 'Bitbucket';

                Repository::firstOrCreate(
                    ['project_id' => $project->id, 'repo_url' => $repoUrl],
                    ['provider' => $provider]
                );
            }
        }

        $this->info("Discovery complete! Added: $added, Updated: $updated.");
    }

    private function detectStack($dir)
    {
        $stacks = [];
        if (file_exists($dir . '/artisan')) $stacks[] = 'Laravel';
        if (file_exists($dir . '/composer.json') && !in_array('Laravel', $stacks)) $stacks[] = 'PHP';
        if (file_exists($dir . '/package.json')) $stacks[] = 'Node.js/JS';
        if (file_exists($dir . '/Gemfile')) $stacks[] = 'Ruby';
        if (file_exists($dir . '/Cargo.toml')) $stacks[] = 'Rust';
        if (file_exists($dir . '/go.mod')) $stacks[] = 'Go';
        if (file_exists($dir . '/requirements.txt') || file_exists($dir . '/pyproject.toml') || file_exists($dir . '/main.py')) $stacks[] = 'Python';
        if (file_exists($dir . '/mix.exs')) $stacks[] = 'Elixir';
        if (file_exists($dir . '/project.clj') || file_exists($dir . '/deps.edn')) $stacks[] = 'Clojure';
        if (file_exists($dir . '/docker-compose.yml') || file_exists($dir . '/Dockerfile')) $stacks[] = 'Docker';
        if (file_exists($dir . '/Project.toml')) $stacks[] = 'Julia';
        if (file_exists($dir . '/nim.cfg') || count(glob($dir . '/*.nim')) > 0) $stacks[] = 'Nim';
        if (count(glob($dir . '/*.rkt')) > 0) $stacks[] = 'Racket';
        if (file_exists($dir . '/Package.swift')) $stacks[] = 'Swift';

        return implode(' + ', $stacks);
    }

    private function detectGitRepo($dir)
    {
        $configPath = $dir . '/.git/config';
        if (file_exists($configPath)) {
            $content = file_get_contents($configPath);
            preg_match('/url\s*=\s*(.+)/', $content, $matches);
            if (!empty($matches[1])) {
                return trim($matches[1]);
            }
        }
        return null;
    }
}
