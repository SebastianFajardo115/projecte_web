<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@bibliojocs.local',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::updateOrCreate([
            'email' => 'user@bibliojocs.local',
        ], [
            'name' => 'User',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::factory(3)->create(['role' => 'user']);
    }
}
