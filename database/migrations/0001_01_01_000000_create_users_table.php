<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('meno');
            $table->string('priezvisko')->default('');
            $table->string('email')->unique();
            $table->string('password');
            // určuje, čo používateľ smie
            $table->string('rola'); // student | vedouci | firma | mentor
            // profilové polia (rôzne podľa roly)
            $table->string('telefon')->default('');
            $table->string('adresa')->default('');
            $table->string('ico')->default('');
            $table->string('sektor')->default('');
            $table->string('web')->default('');
            $table->text('popis')->nullable();
            $table->timestamp('email_verified_at')->nullable(); // kedy bol e-mail overený
            $table->string('verifikacny_token')->nullable();    // jednorazový token na overenie
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};