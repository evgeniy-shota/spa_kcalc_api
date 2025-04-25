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
        Schema::create('diets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete();
            $table->string('name', 255);
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_personal')->default(false);
            $table->string('description', 400)->nullable();
            $table->string('thumbnail_image_path', 255)->nullable();
            // $table->('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
