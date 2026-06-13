<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prihlaska extends Model
{
    protected $table = 'prihlasky';

    protected $fillable = ['user_id', 'program', 'nazov', 'popis', 'oblast', 'motivacia', 'stav'];
}