<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateApiToken extends Command
{
    protected $signature = 'micupanel:token {email : The user the token belongs to} {--name=api : A label for the token}';

    protected $description = 'Issue a personal access token for the MicuPanel API';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error("No user found with email {$this->argument('email')}.");

            return self::FAILURE;
        }

        $token = $user->createToken($this->option('name'));

        $this->info('Token created. Store it now — it will not be shown again:');
        $this->line($token->plainTextToken);

        return self::SUCCESS;
    }
}
