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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()->constrained('categories');
            $table->foreignId('user_id')->nullable()->index()->constrained('users');
            $table->boolean('is_personal')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->string('name', 255);
            $table->string('thumbnail_image_path', 255)->nullable();
            $table->string('manufacturer', 255)->nullable();
            $table->string('country_of_manufacture', 100)->nullable();
            $table->integer('trademark_id')->nullable();
            $table->string('description', 400)->nullable();
            $table->enum('type', ['solid', 'liquid', 'semi-liquid', 'frozen', 'canned', 'bulk'])->default('solid');
            $table->enum('units_of_measurement', ['grams', 'milliliters'])->default('grams');
            $table->integer('quantity_to_calculate')->default(100);
            $table->integer('quantity')->default(100);
            $table->string('product_composition', 800)->nullable();
            $table->float('kcalory', 1)->default(0);
            $table->float('proteins', 1)->default(0);
            $table->float('carbohydrates', 1)->default(0);
            $table->float('fats', 1)->default(0);
            $table->float('kcalory_per_unit', 2)->default(0);
            $table->float('proteins_per_unit', 2)->default(0);
            $table->float('carbohydrates_per_unit', 2)->default(0);
            $table->float('fats_per_unit', 2)->default(0);
            $table->json('nutrients_and_vitamins')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('products');
    }
};
