<?php
// database/migrations/2025_01_01_000005_create_niveaux_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 20); // 1, 2, 3 / L1, L2 ...
            $table->foreignId('departement_id')
                  ->constrained('departements')
                  ->cascadeOnDelete();
            $table->foreignId('specialite_id')
                  ->constrained('specialites')
                  ->cascadeOnDelete();
            $table->foreignId('annee_academique_id')
                  ->constrained('annees_academiques')
                  ->cascadeOnDelete();
            $table->boolean('est_actif')->default(true);
              // Index pour les performances
            $table->index('departement_id');
            $table->index('specialite_id');
            $table->index('annee_academique_id');
            $table->index('est_actif');
            $table->timestamps();
            $table->unique(['specialite_id', 'annee_academique_id', 'libelle']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('niveaux');
    }
};