<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // null = seed
            $table->string('kod')->nullable();        // STA-0001 (firmou vytvorený)
            $table->string('nazov');
            $table->string('oblast');
            $table->string('faza');
            $table->string('lokalita');
            $table->string('vp');
            $table->string('investicia');
            $table->string('zakladatel')->nullable();
            $table->string('kontaktEmail')->nullable();
            $table->string('kontaktTel')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};