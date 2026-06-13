<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milniky', function (Blueprint $table) {
            $table->id();
            // väzba na tím — míľnik patrí konkrétnemu tímu
            $table->foreignId('tim_id')->constrained('timy')->cascadeOnDelete();
            $table->string('nazov');
            $table->boolean('splneny')->default(false); // schválený mentorom?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milniky');
    }
};