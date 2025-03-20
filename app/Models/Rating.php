<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sound_id', 'rating','comment'];

    public function sound()
    {
        return $this->belongsTo(Sound::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
