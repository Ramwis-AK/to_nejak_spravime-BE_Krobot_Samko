<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprava extends Model
{
    protected $table = 'spravy';

    protected $fillable = ['user_id', 'od', 'text'];
}