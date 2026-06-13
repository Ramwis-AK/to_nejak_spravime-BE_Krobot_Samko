<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'meno', 'priezvisko', 'email', 'password', 'rola',
        'telefon', 'adresa', 'ico', 'sektor', 'web', 'popis',
    ];

    // heslo a remember token sa nikdy neposielajú v JSON odpovedi
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed', // automatické hashovanie pri priradení
    ];

    // pomocný atribút: celé meno (pre zobrazenie)
    public function getCeleMenoAttribute(): string
    {
        return trim($this->meno . ' ' . $this->priezvisko);
    }
}