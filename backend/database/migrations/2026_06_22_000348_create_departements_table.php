<?php
// database/migrations/2026_06_22_000003_create_departements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('libelle', 100);
            $table->text('description')->nullable();
            $table->boolean('est_actif')->default(true);
            // chef = un personnel (employé), pas un enseignant
            $table->unsignedBigInteger('chef_departement_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departements');
    }
};