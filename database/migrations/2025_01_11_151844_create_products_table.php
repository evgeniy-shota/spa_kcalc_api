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
            $table->string('name');
            $table->json('product_composition')->nullable();
            $table->string('description')->nullable();
            $table->float('calory');
            $table->float('proteins');
            $table->float('carbohydrates');
            $table->float('fats');
            $table->json('nutrients_and_vitamins')->nullable();
            $table->boolean('is_visible')->default(true);

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
