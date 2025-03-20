<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'super_admin',
            'email' => 'super_admin@example.com',
            'password' => 'password',
            'role' => 'super_admin'
        ]);
        User::create([
            'username' => 'admin_icodsa',
            'email' => 'admin_icodsa@example.com',
            'password' => 'password',
            'role' => 'admin_icodsa'
        ]);
        User::create([
            'username' => 'admin_icicyta',
            'email' => 'admin_icicyta@example.com',
            'password' => 'password',
            'role' => 'admin_icicyta'
        ]);
    }
}
