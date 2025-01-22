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
        Schema::create('personal_user_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users');
            $table->foreignId('personal_user_category_id')->index()->constrained('personal_user_categories');
            $table->string('name', 64)->require();
            $table->json('product_composition')->nullable();
            $table->string('description')->default('');
            $table->float('calory')->require();
            $table->float('protein')->require();
            $table->float('carbohydrates')->require();
            $table->float('fat')->require();
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
        Schema::dropIfExists('personal_user_products');
    }
};
