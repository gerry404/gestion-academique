<?php
// database/seeders/UsersSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'utilisateur Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@edu.cm'],
            [
                'name' => 'Administrateur Principal',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Assigner le rôle Admin
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        
    }
}