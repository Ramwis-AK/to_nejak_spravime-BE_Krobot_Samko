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
        Schema::create('novinky', function (Blueprint $table) {
            $table->id();
            $table->string('titul');
            $table->date('datum');
            $table->string('perex');
            $table->string('kategoria');
            $table->text('obsah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novinky');
    }
};
