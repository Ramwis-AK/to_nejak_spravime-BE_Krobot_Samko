<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prax extends Model
{
    // Eloquent by z "Prax" odvodil zlý názov tabuľky, určíme ho ručne
    protected $table = 'praxe';

    protected $fillable = [
        'firma', 'sektor', 'stav', 'stavKey', 'lokalita', 'zadanie',
        'odmena', 'popis', 'kontaktMeno', 'kontaktEmail', 'kontaktTel',
    ];
}