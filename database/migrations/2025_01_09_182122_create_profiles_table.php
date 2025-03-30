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
            
            $table->foreignId('user_id')->index()->cascadeOnDelete()->constrained('users');
            $table->enum('gender', ['man', 'woman', 'unknow'])->default('unknow');
            $table->date('date_of_birth')->nullable();
            $table->float('height', 1)->nullable();
            $table->enum('level_of_training', ['low', 'medium', 'high', 'very_high', 'unknow'])->default('unknow');
            $table->enum('level_of_daily_activity', ['low', 'medium', 'high', 'very_high', 'unknow'])->default('unknow');
            $table->json('weight')->nullable();
            $table->float('target_weight', 1)->nullable();
            $table->json('target_energy_value_ration')->nullable();
            $table->json('settings')->nullable();

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
