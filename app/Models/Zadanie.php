<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zadanie extends Model
{
    protected $table = 'zadania';

    protected $fillable = ['kod', 'user_id', 'nazov', 'sektor', 'lokalita', 'odmena', 'popis', 'stav'];

    // route binding podľa 'kod' namiesto 'id' (napr. /zadania/ZAD-0001)
    public function getRouteKeyName(): string
    {
        return 'kod';
    }
}