<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentori', function (Blueprint $table) {
            $table->id();
            $table->string('meno');
            $table->string('oblast');
            $table->string('skusenosti');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentori');
    }
};