<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Compte par defaut pour tester la connexion.
     * Identifiants: admin@gestion-scolaire.local / password
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gestion-scolaire.local'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'responsable@gestion-scolaire.local'],
            [
                'name' => 'Responsable Scolarite',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'enseignant@gestion-scolaire.local'],
            [
                'name' => 'Enseignant Demo',
                'password' => Hash::make('password'),
                'role' => 'enseignant',
                'email_verified_at' => now(),
            ]
        );
    }
}
