<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumenty', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // vlastník
            $table->string('nazov');          // pôvodný názov súboru
            $table->string('cesta');          // kde je uložený na disku (neverejné)
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('velkost')->default(0); // v bajtoch
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumenty');
    }
};