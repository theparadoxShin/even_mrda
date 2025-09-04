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
        Schema::create('music_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('composer')->nullable();
            $table->string('file_path');
            $table->string('genre')->default('Religieux');
            $table->integer('duration')->nullable(); // Durée en secondes
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false); // Pour "For Unto Us"
            $table->boolean('is_background')->default(false); // Pour la musique de fond
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_tracks');
    }
};
