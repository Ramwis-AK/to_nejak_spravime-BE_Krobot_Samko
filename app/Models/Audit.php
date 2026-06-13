<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $table = 'audit';
    protected $fillable = ['user_id', 'akcia', 'objekt'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // pomocný zápis do auditu
    public static function zapis(int $userId, string $akcia, string $objekt = null): void
    {
        self::create(['user_id' => $userId, 'akcia' => $akcia, 'objekt' => $objekt]);
    }
}