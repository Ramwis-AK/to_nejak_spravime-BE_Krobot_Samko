<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vyzva extends Model
{
    protected $table = 'vyzvy';

    protected $fillable = [
        'nazov', 'program', 'popis', 'otvorenie', 'deadline', 'stav',
        'kategorie', 'kriteria', 'dokumenty', 'faq',
    ];

    // automatický prevod dátumov a JSON polí na/z PHP typov
    protected $casts = [
        'otvorenie' => 'date:Y-m-d',
        'deadline'  => 'date:Y-m-d',
        'kategorie' => 'array',
        'kriteria'  => 'array',
        'dokumenty' => 'array',
        'faq'       => 'array',
    ];
}