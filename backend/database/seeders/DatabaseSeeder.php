<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Matiere;
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

        if (Etudiant::count() === 0) {
            Etudiant::factory()->count(15)->create();
        }

        $matieres = [
            ['code' => 'MATH101', 'libelle' => 'Mathematiques', 'coefficient' => 4],
            ['code' => 'INFO101', 'libelle' => 'Algorithmique', 'coefficient' => 3],
            ['code' => 'PHYS101', 'libelle' => 'Physique', 'coefficient' => 3],
            ['code' => 'ANG101', 'libelle' => 'Anglais', 'coefficient' => 2],
            ['code' => 'FR101', 'libelle' => 'Francais', 'coefficient' => 2],
        ];

        foreach ($matieres as $matiere) {
            Matiere::updateOrCreate(['code' => $matiere['code']], $matiere);
        }
    }
}
