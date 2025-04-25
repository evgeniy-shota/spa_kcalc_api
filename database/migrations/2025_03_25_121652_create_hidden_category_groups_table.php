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
        Schema::create('hidden_category_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_group_id')->index()->constrained('category_groups')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hidden_category_groups');
    }
};
