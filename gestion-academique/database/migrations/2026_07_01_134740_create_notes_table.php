<?php
// database/migrations/[timestamp]_create_notes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->foreignId('inscription_id')->constrained('inscriptions')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestres')->onDelete('cascade');
            $table->decimal('note_cc', 5, 2)->nullable();
            $table->decimal('note_examen', 5, 2)->nullable();
            $table->decimal('moyenne', 5, 2)->nullable();
            $table->integer('credit')->default(0);
            $table->timestamps();

            // Empêcher les doublons
            $table->unique(['etudiant_id', 'matiere_id', 'inscription_id'], 'unique_note');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};