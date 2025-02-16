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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->nullable()->constrained('users');
            $table->string('name', 100);
            // $table->enum('type', ['product', 'activity'])->default();
            $table->boolean('is_enable')->default(true);
            $table->boolean('is_personal')->default(false);
            $table->string('description', 300)->nullable();
            $table->string('icon_path', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
