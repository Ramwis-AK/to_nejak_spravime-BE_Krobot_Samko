<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rozpocty', function (Blueprint $table) {
            $table->id();
            // jeden rozpočet na firmu (unique)
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('schvaleny', 12, 2)->default(0);
            $table->decimal('cerpane', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rozpocty');
    }
};