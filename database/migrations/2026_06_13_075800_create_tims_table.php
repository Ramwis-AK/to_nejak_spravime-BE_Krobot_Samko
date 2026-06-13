<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timy', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();             // TIM-0001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();   // vedúci
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nazov');
            $table->string('projekt')->default('');
            $table->string('program')->default('Program A');
            $table->timestamps();
        });

        Schema::create('tim_clenovia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('timy')->cascadeOnDelete();
            $table->string('meno');
            $table->string('telefon')->default('');
            $table->timestamps();
        });

        Schema::create('milniky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('timy')->cascadeOnDelete();
            $table->string('nazov');
            $table->boolean('splneny')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milniky');
        Schema::dropIfExists('tim_clenovia');
        Schema::dropIfExists('timy');
    }
};