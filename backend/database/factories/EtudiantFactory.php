<?php

namespace Database\Factories;

use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    protected $model = Etudiant::class;

    public function definition(): array
    {
        $sexe = $this->faker->randomElement(['M', 'F']);

        return [
            'matricule' => strtoupper($this->faker->unique()->bothify('ET####??')),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName($sexe === 'M' ? 'male' : 'female'),
            'sexe' => $sexe,
            'date_naissance' => $this->faker->dateTimeBetween('-30 years', '-17 years')->format('Y-m-d'),
            'lieu_naissance' => $this->faker->city(),
            'email' => $this->faker->optional()->safeEmail(),
            'telephone' => $this->faker->optional()->numerify('06########'),
            'adresse' => $this->faker->optional()->streetAddress(),
        ];
    }
}
