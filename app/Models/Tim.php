<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'timy';

    protected $fillable = ['kod', 'user_id', 'mentor_id', 'nazov', 'projekt', 'program'];

    public function getRouteKeyName(): string
    {
        return 'kod';
    }

    public function clenovia()
    {
        return $this->hasMany(TimClen::class, 'tim_id');
    }

    public function milniky()
    {
        return $this->hasMany(Milnik::class, 'tim_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}