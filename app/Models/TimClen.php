<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimClen extends Model
{
    protected $table = 'tim_clenovia';

    protected $fillable = ['tim_id', 'meno', 'telefon'];
}