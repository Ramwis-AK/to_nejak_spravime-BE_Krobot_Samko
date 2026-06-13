<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tim_clenovia', function (Blueprint $table) {
            $table->id();
            // väzba na tím — pri zmazaní tímu sa zmažú aj jeho členovia
            $table->foreignId('tim_id')->constrained('timy')->cascadeOnDelete();
            $table->string('meno');
            $table->string('telefon')->default('');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_clenovia');
    }
};