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
        Schema::create('game_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_topic_id')->constrained('sub_topics')->onDelete('cascade'); // Foreign key to sub_topics table
            $table->string('code')->unique(); // Unique game code
            $table->string('game_url')->nullable(); // Optional thumbnail for the sub-topic
            $table->enum('level', ['inferior', 'reguler', 'superior'])->default('inferior'); // Level of the game code
            $table->text('description')->nullable(); // Optional description for the game code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_codes');
    }
};