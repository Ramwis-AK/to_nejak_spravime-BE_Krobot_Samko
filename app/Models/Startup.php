<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    // povolené hromadné priradenie (mass assignment) — chráni pred nechcenými poliami
    protected $fillable = [
        'nazov', 'oblast', 'faza', 'lokalita', 'vp', 'investicia',
        'zakladatel', 'kontaktEmail', 'kontaktTel',
    ];
}