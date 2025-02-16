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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->nullable()->constrained('users');
            $table->foreignId('activity_category_id')->index()->constrained('activity_categories');
            $table->boolean('is_personal')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->string('name', 255);
            $table->string('description', 600)->nullable();
            $table->enum('type_of_load', ['duration', 'quantity'])->default('duration');
            $table->integer('duration_sec_to_calculate')->default(60);
            $table->integer('quantity_to_calculate')->default(1);
            $table->integer('energy_cost')->default(0);
            $table->float('energy_cost_per_unit', 3)->default(0);
            $table->string('thumbnail_image_path', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
