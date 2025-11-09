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
        Schema::create('student_final_test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_final_test_id')->constrained()->onDelete('cascade');
            $table->foreignId('final_test_id')->constrained()->onDelete('cascade');
            
            // Index soal (untuk multiple questions dalam satu tes)
            $table->integer('question_index')->default(0);
            
            $table->text('answer_text')->nullable();
            $table->string('answer_file')->nullable();
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_final_test_answers');
    }
};