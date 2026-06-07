<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create (or update) the one admin account this dashboard needs.
     *
     * The email and password come from the environment so that real
     * credentials never have to be written into a file that gets
     * committed to GitHub. Set ADMIN_NAME / ADMIN_EMAIL / ADMIN_PASSWORD
     * in .env locally, and in Coolify's environment variables on the
     * live server.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'agbozomykell8@gmail.com');
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            $this->command?->warn('ADMIN_PASSWORD is not set — skipping admin seeder. Add it to your .env and re-run.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Michael Agbozo'),
                'password' => Hash::make($password),
            ]
        );

        $this->command?->info("Admin account ready for {$email}.");
    }
}
