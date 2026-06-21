<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base de données de test à chaque lancement

    /**
     * Teste le cycle de vie complet de l'authentification Admin.
     */
    public function test_complete_admin_auth_lifecycle(): void
    {
        // 1. Initialiser les rôles et l'admin par défaut via le seeder
        $this->seed(RoleAndPermissionSeeder::class);

        // 2. TEST DU LOGIN
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'admin@academique.com',
            'password' => 'Admin2026!',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email', 'roles'],
                'token'
            ]);

        // Récupérer le token généré pour les requêtes suivantes
        $token = $loginResponse->json('token');

        // 3. TEST DE LA ROUTE /ME (Vérification du profil avec le Token)
        $meResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/me');

        $meResponse->assertStatus(200)
            ->assertJsonPath('user.email', 'admin@academique.com');

        // 4. TEST DE LA DÉCONNEXION (LOGOUT)
        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson(['message' => 'Deconnexion reussie.']);
    }
}
