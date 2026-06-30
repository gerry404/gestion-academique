<?php
// database/migrations/[timestamp]_add_niveau_id_to_semestres_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('semestres', function (Blueprint $table) {
            // Ajouter la colonne niveau_id
            $table->foreignId('niveau_id')
                  ->nullable()
                  ->constrained('niveaux')
                  ->onDelete('cascade');
            
            // Ajouter un index pour les performances
            $table->index('niveau_id');
        });
    }

    public function down(): void
    {
        Schema::table('semestres', function (Blueprint $table) {
            $table->dropForeign(['niveau_id']);
            $table->dropColumn('niveau_id');
        });
    }
};