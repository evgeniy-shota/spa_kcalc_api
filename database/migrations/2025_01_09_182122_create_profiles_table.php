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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users');
            $table->enum('gender', ['man', 'woman'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->float('height',1)->nullable();
            $table->enum('level_of_training', ['low', 'medium', 'hgh', 'profi'])->nullable();
            $table->enum('daily_activity_level', ['low', 'medium', 'high', 'very_nigh'])->nullable();
            $table->float('weight',1)->nullable();
            $table->float('target_weight',1)->nullable();
            $table->json('target_energy_value_ration')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
