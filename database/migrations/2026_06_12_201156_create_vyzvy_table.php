<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vyzvy', function (Blueprint $table) {
            $table->id();
            $table->string('nazov');
            $table->string('program');               // Program A / Program B
            $table->text('popis')->nullable();
            $table->date('otvorenie')->nullable();    // začiatok kola
            $table->date('deadline');                 // termín uzávierky
            $table->string('stav')->default('Otvorená');
            // Zoznamy ukladáme ako JSON (§7.1 kategórie/stacky, §7.2 kritériá, §7.3 dokumenty, FAQ)
            $table->json('kategorie')->nullable();
            $table->json('kriteria')->nullable();
            $table->json('dokumenty')->nullable();
            $table->json('faq')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vyzvy');
    }
};