<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vyzva extends Model
{
    protected $table = 'vyzvy';

    protected $fillable = ['nazov', 'program', 'popis', 'deadline', 'stav'];

    protected $casts = ['deadline' => 'date:Y-m-d'];
}