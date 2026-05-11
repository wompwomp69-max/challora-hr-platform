<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class CreateHrUser extends Command
{
    protected $signature = 'user:create-hr {email} {password} {name}';
    protected $description = 'Create an HR user account';

    public function handle(): void
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'role' => UserRole::HR,
        ]);

        $this->info("HR user created: {$user->email}");
    }
}
