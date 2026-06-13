<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zadania', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();            // ZAD-0001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // firma-vlastník
            $table->string('nazov');
            $table->string('sektor')->default('');
            $table->string('lokalita')->default('');
            $table->string('odmena')->default('');
            $table->text('popis')->nullable();
            $table->string('stav')->default('Otvorené');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zadania');
    }
};