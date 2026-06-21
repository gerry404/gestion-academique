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
        $this->call([
              RoleAndPermissionSeeder::class,
        ]);
    }
}
