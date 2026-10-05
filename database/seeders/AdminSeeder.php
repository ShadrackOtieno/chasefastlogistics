<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Set ADMIN_EMAIL / ADMIN_PASSWORD in .env before seeding, or change the password after first login.
        $email = env('ADMIN_EMAIL', 'admin@chasefastlogistics.com');
        $password = env('ADMIN_PASSWORD', 'ChangeMe!2026');

        User::updateOrCreate(
            ['email' => $email],
            ['name' => 'Administrator', 'password' => $password, 'is_admin' => true]
        );

        $this->command?->warn("Admin login: {$email} / {$password}  (change this after first login)");
    }
}
