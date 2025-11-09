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
        Schema::create('sub_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('topics')->onDelete('cascade'); // Foreign key to topics table
            $table->string('title'); // Title of the sub-topic
            $table->text('description')->nullable(); // Optional description for the sub-topic
            $table->string('thumbnail_url')->nullable(); // Optional thumbnail for the topic
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_topics');
    }
};