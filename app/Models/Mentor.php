<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentori';

    protected $fillable = ['meno', 'oblast', 'skusenosti'];
}