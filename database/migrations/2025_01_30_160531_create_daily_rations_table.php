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
        Schema::create('daily_rations', function (Blueprint $table) {
            $table->id();
            // $table->time('time_of_use');
            $table->foreignId('user_id')->index()->constrained('users');
            $table->string('description', 255)->nullable();
            // $table->foreignId('daily_ration_product_id')->index()->constrained('daily_ration_products')->nullable();
            // $table->json('ration_summary')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_rations');
    }
};
