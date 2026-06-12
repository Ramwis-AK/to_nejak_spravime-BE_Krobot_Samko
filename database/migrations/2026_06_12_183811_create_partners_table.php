<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partneri', function (Blueprint $table) {
            $table->id();
            $table->string('nazov');
            $table->string('typ');           // Akademický / Firemný / Ekosystém
            $table->text('popis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partneri');
    }
};