<?php
// database/migrations/2026_06_22_000004_add_fk_chef_departement.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->foreign('chef_departement_id')
                  ->references('id')
                  ->on('personnels')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->dropForeign(['chef_departement_id']);
        });
    }
};