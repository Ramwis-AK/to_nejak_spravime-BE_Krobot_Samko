<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rozpocet extends Model
{
    protected $table = 'rozpocty';

    protected $fillable = ['user_id', 'schvaleny', 'cerpane'];

    protected $casts = ['schvaleny' => 'float', 'cerpane' => 'float'];
}