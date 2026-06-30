<?php

namespace Tests\Feature\Api\Etablissement;

use App\Models\Etablissement\Personnel;
use App\Models\Etablissement\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PersonnelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'Employe', 'guard_name' => 'sanctum']);
    }

    public function test_employe_can_view_personnels()
    {
        $user = User::create(['name' => 'Employe User', 'email' => 'emp1@test.com', 'password' => 'password']);
        $user->assignRole('Employe');

        Personnel::create([
            'matricule' => 'P001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john@test.com'
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/personnels');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'matricule', 'nom', 'prenom', 'email']
            ],
            'meta',
            'links'
        ]);
    }

    public function test_employe_cannot_create_personnel()
    {
        $user = User::create(['name' => 'Employe User 2', 'email' => 'emp2@test.com', 'password' => 'password']);
        $user->assignRole('Employe');

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/personnels', [
            'matricule' => 'P002',
            'nom' => 'Smith',
            'prenom' => 'Jane',
            'email' => 'jane@test.com'
        ]);

        $response->assertStatus(403);
    }
}
