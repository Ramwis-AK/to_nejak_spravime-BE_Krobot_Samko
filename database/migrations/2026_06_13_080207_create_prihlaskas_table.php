<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prihlasky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('prax_id')->nullable();   // zadanie Programu B
            $table->string('program');
            $table->string('nazov');
            $table->text('popis')->nullable();
            $table->string('oblast')->default('');
            $table->text('motivacia')->nullable();
            $table->string('stav')->default('Podaná');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prihlasky');
    }
};