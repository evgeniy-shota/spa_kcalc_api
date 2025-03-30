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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dish_category_id')->index()->nullOnDelete()->constrained('dish_categories');
            $table->foreignId('user_id')->index()->nullable()->constrained('users');
            $table->string('name', 255);
            $table->boolean('is_personal')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->string('description', 800)->nullable();
            $table->integer('quantity_to_calculate')->default(100);
            $table->integer('quantity')->default(100);
            $table->float('kcalory', 1)->default(0);
            $table->float('proteins', 1)->default(0);
            $table->float('carbohydrates', 1)->default(0);
            $table->float('fats', 1)->default(0);
            $table->float('kcalory_per_unit', 2)->default(0);
            $table->float('proteins_per_unit', 2)->default(0);
            $table->float('carbohydrates_per_unit', 2)->default(0);
            $table->float('fats_per_unit', 2)->default(0);
            $table->foreignId('data_source')->index()->nullable()->constrained();
            $table->json('nutrients_and_vitamins')->nullable();
            // $table->integer('tags');
            $table->string('thumbnail_image_path', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
