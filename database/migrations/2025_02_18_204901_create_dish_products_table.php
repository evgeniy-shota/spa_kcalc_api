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
        Schema::create('dish_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dish_id')->index()->constrained('dishes');
            $table->foreignId('product_id')->index()->constrained('products');
            $table->integer('quantity')->default(100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_products');
    }
};
