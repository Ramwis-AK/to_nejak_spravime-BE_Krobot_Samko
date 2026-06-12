<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontaktSprava extends Model
{
    protected $table = 'kontakt_spravy';

    protected $fillable = ['meno', 'email', 'telefon', 'tema', 'sprava', 'gdpr'];

    protected $casts = ['gdpr' => 'boolean'];
}