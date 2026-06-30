<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annees_academiques', function (Blueprint $table) {
            $table->id();

            $table->string('libelle', 20)->unique();
            $table->date('date_debut')
            ->nullable();
            $table->date('date_fin')
            ->nullable();

            $table->decimal('note_validation', 4, 2)
                ->default(10);

            $table->boolean('est_active')
                ->default(false);

            $table->text('description')
                ->nullable();

            $table->timestamps();

            $table->index('est_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annees_academiques');
    }
};