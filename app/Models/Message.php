<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public function guid()
    {
        return $this->belongsTo(Guid::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
