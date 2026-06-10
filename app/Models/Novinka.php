<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novinka extends Model
{
    // tabuľka sa volá "novinky", nie default "novinkas"
    protected $table = 'novinky';

    protected $fillable = ['titul', 'datum', 'perex', 'kategoria', 'obsah'];

    protected $casts = [
        'datum' => 'date:Y-m-d',
    ];
}