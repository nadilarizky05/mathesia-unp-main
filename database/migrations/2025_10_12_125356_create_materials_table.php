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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_topic_id')->constrained('sub_topics')->onDelete('cascade'); // Foreign key to sub_topics table
            $table->string('title'); // Title of the material
            $table->enum('level', ['inferior', 'reguler', 'superior'])->default('inferior'); // Level of the material
            $table->longText('content')->nullable(); // Content of the material
            $table->string('file_url')->nullable(); // URL to the file associated with the material
            $table->string('video_url')->nullable(); // URL to the video associated with the material
            $table->integer('order')->default(0); // Order of the material in the sub-topic

            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};