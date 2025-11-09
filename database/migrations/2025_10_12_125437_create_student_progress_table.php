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
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('sub_topic_id')->constrained('sub_topics')->onDelete('cascade'); // Foreign key to sub_topics table
            $table->foreignId('game_code_id')->nullable()->constrained('game_codes')->onDelete('set null'); // Foreign key to game_codes table, nullable
            $table->foreignId('material_id')->nullable()->constrained('materials')->onDelete('set null'); // Foreign key to materials table, nullable
            $table->enum('level', ['inferior', 'reguler', 'superior'])->default('inferior'); // Level of the progress
            $table->boolean('is_completed')->default(false); // Completion status
            $table->timestamp('completed_at')->nullable(); // Timestamp when the sub-topic was completed
            $table->integer('active_section')->default(1);
            $table->json('completed_section')->nullable();
            $table->integer('progress_percent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};