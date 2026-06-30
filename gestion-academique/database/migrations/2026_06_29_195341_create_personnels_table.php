<?php
// database/migrations/2026_06_22_000001_create_personnels_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 20)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance', 100)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email', 150)->nullable()->unique();
            $table->string('adresse', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('diplome', 255)->nullable();
            $table->string('fonction', 100)->nullable(); // Directeur, Secrétaire...
            $table->date('date_embauche')->nullable();
            $table->boolean('est_actif')->default(true);
            // Lien vers un compte user (optionnel, créé par l'admin)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('specialite',100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};