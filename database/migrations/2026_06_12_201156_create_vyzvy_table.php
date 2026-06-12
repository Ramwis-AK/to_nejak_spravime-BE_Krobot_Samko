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
            $table->string('program');   // Program A / Program B
            $table->text('popis')->nullable();
            $table->date('deadline');
            $table->string('stav')->default('Otvorená'); // Otvorená / Uzavretá
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vyzvy');
    }
};