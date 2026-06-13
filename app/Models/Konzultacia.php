<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konzultacia extends Model
{
    protected $table = 'konzultacie';

    protected $fillable = ['tim_id', 'mentor_id', 'text'];
}