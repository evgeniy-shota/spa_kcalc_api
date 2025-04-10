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
            $table->boolean('is_abstract')->default(true);
            $table->string('name', 255);
            $table->string('thumbnail_image_name', 255)->nullable();
            $table->foreignId('manufacturer_id')->nullable()->constrained('manufacturers');
            $table->foreignId('country_of_manufacture_id')->nullable()->constrained('country_of_manufactures');
            $table->integer('trademark_id')->nullable();
            $table->string('description', 400)->nullable();
            $table->foreignId('type_id')->nullable()->constrained('product_types');
            $table->enum('condition', ['solid', 'liquid', 'semi-liquid', 'bulk'])->default('solid');
            $table->enum('state', ['chilled', 'frozen', 'fresh'])->nullable();
            $table->enum('units', ['gr', 'ml'])->default('gr');
            $table->integer('quantity_to_calculate')->default(100);
            $table->integer('quantity')->default(100)->nullable();
            $table->string('composition', 800)->nullable();
            $table->float('kcalory', 1)->default(0);
            $table->float('proteins', 1)->default(0);
            $table->float('carbohydrates', 1)->default(0);
            $table->float('fats', 1)->default(0);
            $table->float('kcalory_per_unit', 2)->default(0);
            $table->float('proteins_per_unit', 2)->default(0);
            $table->float('carbohydrates_per_unit', 2)->default(0);
            $table->float('fats_per_unit', 2)->default(0);
            $table->foreignId('data_source')->nullable()->constrained();
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
