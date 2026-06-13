<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokument extends Model
{
    protected $table = 'dokumenty';

    protected $fillable = ['user_id', 'nazov', 'cesta', 'mime', 'velkost'];

    // cestu na disku nikdy neposielame do frontendu (bezpečnosť)
    protected $hidden = ['cesta'];
}