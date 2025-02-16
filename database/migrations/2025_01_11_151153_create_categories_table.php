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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index()->constrained('users');
            $table->string('name', 100);
            $table->string('description', 400)->nullable();
            $table->boolean('is_personal')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->string('icon_path',255)->nullable();
            $table->string('thumbnail_image_path',255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
