<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            
            // Attempt metadata
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->boolean('is_submitted')->default(false);
            
            // Jawaban per soal (JSON array)
            // Format: [{question_index: 0, answer_text: "...", answer_file: "path", score: null}, ...]
            $table->json('answers')->nullable();
            
            // Total nilai
            $table->integer('total_score')->nullable();
            
            $table->timestamps();
            
            // Constraint: 1 user hanya bisa punya 1 active attempt per material
            $table->unique(['user_id', 'material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_test_answers');
    }
};