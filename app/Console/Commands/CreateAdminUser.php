<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    protected $signature = 'micupanel:user {email} {--name=Admin} {--password=}';

    protected $description = 'Create or update the MicuPanel login user (registration is disabled)';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->option('password') ?: $this->secret('Password (min 8 characters)');

        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => ['required', 'email'], 'password' => ['required', Password::min(8)]],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $this->option('name'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ],
        );

        $this->info(($user->wasRecentlyCreated ? 'Created' : 'Updated')." login user {$email}.");

        return self::SUCCESS;
    }
}
