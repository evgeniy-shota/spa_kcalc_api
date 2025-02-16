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
        Schema::create('daily_ration_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_ration_id')->index()->constrained('daily_rations');
            $table->foreignId('product_id')->index()->constrained('products');
            // $table->integer('diet_id')->index()->nullable()->constrained('diets');
            $table->integer('diet_id')->nullable();
            $table->time('time');
            // $table->string('name', 255);
            $table->integer('quantity')->default(100);
            // $table->float('kcalory_per_unit', 2)->default(0);
            // $table->float('proteins_per_unit', 2)->default(0);
            // $table->float('carbohydrates_per_unit', 2)->default(0);
            // $table->float('fats_per_unit', 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_ration_products');
    }
};
