<?php
// database/migrations/2026_06_22_000009_create_diplomes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('diplomes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('libelle', 100);
            $table->text('description')->nullable();
            $table->integer('duree_annees')->default(3);
            $table->string('niveau_requis', 20)->nullable(); // BAC, BAC+2, etc.
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diplomes');
    }
};