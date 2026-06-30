<?php

namespace Database\Seeders;

use App\Models\Etablissement\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nettoyer le cache Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Créer les rôles pour les deux environnements (Web et API)
        Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'employe', 'guard_name' => 'web']);
        
        $adminRoleSanctum = Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'employe', 'guard_name' => 'sanctum']);

        // 3. Créer ou récupérer l'admin par défaut
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@academique.com'],
            [
                'name'     => 'Administrateur Principal',
                'password' => Hash::make('Admin2026!'),
            ]
        );

        // 4. Assigner directement le rôle configuré pour Sanctum
        if (! $adminUser->hasRole('admin', 'sanctum')) {
            $adminUser->assignRole($adminRoleSanctum);
        }

        $this->command->info('✅ Admin créé : admin@academique.com / Admin2026!');
    }
}
