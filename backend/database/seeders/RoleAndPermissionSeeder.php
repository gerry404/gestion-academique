<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nettoyer le cache Spatie (Évite les bugs en équipe)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Créer les rôles s'ils n'existent pas
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeRole = Role::firstOrCreate(['name' => 'employe']);

        // 3. Créer l'administrateur par défaut
        // updateOrCreate évite les doublons si vous relancez le seeder plusieurs fois
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@academique.com'], // Condition de recherche
            [
                'name' => 'Administrateur Principal',
                'password' => Hash::make('Admin2026!'), // Utilisez un mot de passe fort
            ]
        );

        // 4. Assigner le rôle admin à cet utilisateur
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }
        
        $this->command->info('Administrateur par defaut cree avec succes : admin@academique.com / PasswordAdmin2026!');
    }
}
