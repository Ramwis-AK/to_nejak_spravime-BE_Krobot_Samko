<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konzultacie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('timy')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->text('text');   // zápis / komentár k progresu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konzultacie');
    }
};