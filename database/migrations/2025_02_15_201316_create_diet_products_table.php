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
        Schema::create('diet_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_id')->index()->constrained('diets');
            $table->foreignId('product_id')->index()->constrained('products');
            $table->string('name', 255);
            $table->integer('quantity')->default(100);
            $table->float('kcalory_per_unit');
            $table->float('proteins_per_unit');
            $table->float('carbohydrates_per_unit');
            $table->float('fats_per_unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_products');
    }
};
