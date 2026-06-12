<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('praxe', function (Blueprint $table) {
            $table->id();
            $table->string('firma');
            $table->string('sektor');
            $table->string('stav');          // čitateľný text: Otvorené...
            $table->string('stavKey');       // strojový kľúč: open/pairing/active
            $table->string('lokalita');
            $table->string('zadanie');
            $table->string('odmena');
            $table->text('popis')->nullable();
            // kontakt na zadávateľa (detail stránka)
            $table->string('kontaktMeno')->nullable();
            $table->string('kontaktEmail')->nullable();
            $table->string('kontaktTel')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('praxe');
    }
};