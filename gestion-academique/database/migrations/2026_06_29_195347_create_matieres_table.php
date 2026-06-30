<?php
// database/migrations/2026_06_22_000008_create_matieres_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('libelle', 150);
            $table->integer('credit')->default(1);
            $table->foreignId('departement_id')
                  ->constrained('departements')
                  ->cascadeOnDelete();
            $table->foreignId('unite_enseignement_id')
                  ->constrained('unites_enseignement')
                  ->cascadeOnDelete();
            $table->foreignId('semestre_id')
                  ->constrained('semestres')
                  ->cascadeOnDelete();
            // ✅ CORRECTION : pointe vers personnels (pas enseignants)
            $table->foreignId('personnel_id')
                  ->nullable()
                  ->constrained('personnels')
                  ->nullOnDelete();
            $table->foreignId('niveau_id')
                  ->constrained('niveaux')
                  ->cascadeOnDelete();
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};