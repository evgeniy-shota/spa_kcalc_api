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
        Schema::create('data_sources', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);
            $table->string('name_orig', 150)->nullable();
            $table->string('description_ru', 600)->nullable();
            $table->string('description_en', 600)->nullable();
            $table->string('citation', 400)->nullable();
            $table->string('thumbnail_image_name', 255)->nullable();
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sources');
    }
};
