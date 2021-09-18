<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public function destination()
    {
        return $this->belongsTo(User::class, 'des_user');
    }

    public function source()
    {
        return $this->belongsTo(User::class, 'src_user');
    }
}
