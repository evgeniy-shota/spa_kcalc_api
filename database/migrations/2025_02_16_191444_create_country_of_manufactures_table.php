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
        Schema::create('country_of_manufactures', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru', 100);
            $table->string('name_en', 100)->nullable();
            $table->string('flag_path', 255)->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_of_manufactures');
    }
};
