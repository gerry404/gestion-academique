<?php

namespace Tests\Feature\Api\Etablissement;

use App\Models\Etablissement\Departement;
use App\Models\Etablissement\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DepartementControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'Employe', 'guard_name' => 'sanctum']);
    }

    public function test_employe_can_view_departements()
    {
        $user = User::create(['name' => 'Employe User', 'email' => 'emp1@test.com', 'password' => 'password']);
        $user->assignRole('Employe');

        Departement::create(['code' => 'DEP1', 'libelle' => 'Dep 1']);
        Departement::create(['code' => 'DEP2', 'libelle' => 'Dep 2']);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/departements');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'libelle', 'description', 'est_actif', 'chef_departement_id']
            ],
            'meta',
            'links'
        ]);
    }

    public function test_employe_cannot_create_departement()
    {
        $user = User::create(['name' => 'Employe User 2', 'email' => 'emp2@test.com', 'password' => 'password']);
        $user->assignRole('Employe');

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/departements', [
            'code' => 'INFO',
            'libelle' => 'Informatique',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_create_departement()
    {
        $user = User::create(['name' => 'Admin User', 'email' => 'admin@test.com', 'password' => 'password']);
        $user->assignRole('Admin');

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/departements', [
            'code' => 'INFO',
            'libelle' => 'Informatique',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('departements', ['code' => 'INFO']);
    }
}
