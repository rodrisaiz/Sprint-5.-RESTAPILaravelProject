<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'dice_1',
        'dice_2',
        'result'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function player_id()
    {
        return $this->belongsTo(User::class, 'id');
    }

}
