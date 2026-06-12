<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontakt_spravy', function (Blueprint $table) {
            $table->id();
            $table->string('meno');
            $table->string('email');
            $table->string('telefon')->nullable();
            $table->string('tema')->nullable();
            $table->text('sprava');
            $table->boolean('gdpr')->default(false); // súhlas so spracovaním (§13)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontakt_spravy');
    }
};