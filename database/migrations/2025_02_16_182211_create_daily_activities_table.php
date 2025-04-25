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
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete();
            $table->foreignId('activity_id')->index()->constrained('activities')->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->string('description', 255)->nullable();
            $table->integer('duration_sec')->default(60);
            $table->integer('quantity')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
