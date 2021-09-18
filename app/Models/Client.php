<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
