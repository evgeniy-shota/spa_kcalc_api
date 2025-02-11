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
            $table->boolean('is_visible')->default(true);
            $table->string('name', 255);
            $table->string('manufacturer', 128)->nullable();
            $table->string('country_of_manufacture', 64)->nullable();
            $table->foreignId('trademark_id')->nullable()->index()->constrained('trademarks');
            $table->string('description', 255)->nullable();
            $table->enum('units_of_measurement', ['weight', 'qantity', 'volume'])->default('weight');
            $table->float('quantity_to_calculate')->default(100);
            $table->float('quantity')->default(100);
            $table->string('product_composition', 512)->nullable();
            $table->float('kcalory');
            $table->float('proteins');
            $table->float('carbohydrates');
            $table->float('fats');
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
