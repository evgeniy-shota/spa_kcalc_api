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
        Schema::create('trademarks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->foreignId('user_id')->index()->nullable()->constrained('users');
            $table->string('description', 400)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_personal')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trademarks');
    }
};
