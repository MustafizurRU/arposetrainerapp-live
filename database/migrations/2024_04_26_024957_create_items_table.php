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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('level_name' , ['level1', 'level2', 'level3', 'level4','level5'])->default('level1');
            $table->integer('level_wise_score')->nullable();
            $table -> enum('level_performance',['poor', 'fair', 'moderate', 'good', 'excellent'])->default('poor');
            $table->text('pose_image_url',200)->nullable();
            $table->timestamps();
            // Add unique constraint
            $table->unique(['user_id', 'level_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
