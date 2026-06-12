// database/migrations/2026_06_10_141000_create_startups_table.php
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
            $table->string('nazov');
            $table->string('oblast');
            $table->string('faza');          // Pre-seed / Seed / Series A
            $table->string('lokalita');
            $table->string('vp');            // value proposition
            $table->string('investicia');
            // kontaktné údaje na zakladateľa (detail stránka)
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