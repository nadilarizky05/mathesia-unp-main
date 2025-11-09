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
        Schema::create('material_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->integer('order')->default(1);
            $table->string('title')->nullable(); // optional: "Section 1", "Section 2", dst
            $table->text('wacana')->nullable();
            $table->text('masalah')->nullable();
            $table->text('berpikir_soal_1')->nullable();
            $table->text('berpikir_soal_2')->nullable();
            $table->text('rencanakan')->nullable();
            $table->text('selesaikan')->nullable();
            $table->text('periksa')->nullable();
            $table->text('kerjakan_1')->nullable();
            $table->text('kerjakan_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_sections');
    }
};
