<?php
// database/migrations/[timestamp]_add_unique_constraint_to_semestres.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer les éventuels doublons existants
        DB::statement('
            DELETE s1 FROM semestres s1
            INNER JOIN semestres s2 
            WHERE s1.id > s2.id 
            AND s1.libelle = s2.libelle 
            AND s1.annee_academique_id = s2.annee_academique_id 
            AND s1.niveau_id = s2.niveau_id
        ');

        // Ajouter la contrainte unique
        Schema::table('semestres', function (Blueprint $table) {
            $table->unique(['libelle', 'annee_academique_id', 'niveau_id'], 'unique_semestre_per_annee_niveau');
        });
    }

    public function down(): void
    {
        Schema::table('semestres', function (Blueprint $table) {
            $table->dropUnique('unique_semestre_per_annee_niveau');
        });
    }
};