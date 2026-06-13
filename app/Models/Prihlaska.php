<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prihlaska extends Model
{
    protected $table = 'prihlasky';

    protected $fillable = ['user_id', 'prax_id', 'program', 'nazov', 'popis', 'oblast', 'motivacia', 'stav', 'skore', 'komentar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prax()
    {
        return $this->belongsTo(Prax::class, 'prax_id');
    }
}