<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milnik extends Model
{
    protected $table = 'milniky';

    protected $fillable = ['tim_id', 'nazov', 'splneny'];

    protected $casts = ['splneny' => 'boolean'];
}