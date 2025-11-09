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
        Schema::create('teams_members', function (Blueprint $table) {
            $table->id();
             $table->foreignId('teams_id')->constrained('teams')->onDelete('cascade');
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('avatar_url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams_members');
    }
};