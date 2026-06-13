<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('praxe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // null = seed dáta
            $table->string('kod')->nullable();        // ZAD-0001 (firemné zadanie)
            $table->string('firma');
            $table->string('sektor');
            $table->string('stav');
            $table->string('stavKey');
            $table->string('lokalita');
            $table->string('zadanie');
            $table->string('odmena');
            $table->text('popis')->nullable();
            $table->string('kontaktMeno')->nullable();
            $table->string('kontaktEmail')->nullable();
            $table->string('kontaktTel')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('praxe');
    }
};