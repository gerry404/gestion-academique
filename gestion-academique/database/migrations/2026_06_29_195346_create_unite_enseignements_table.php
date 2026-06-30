<?php
// database/migrations/2025_01_01_000007_create_unites_enseignement_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('unites_enseignement', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('libelle', 150);
            $table->integer('total_credit')->default(0);
            $table->integer('position_releve')->default(1);
            $table->foreignId('annee_academique_id')
                  ->constrained('annees_academiques')
                  ->cascadeOnDelete();
            $table->foreignId('niveau_id')
                  ->constrained('niveaux')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('unites_enseignement');
    }
};