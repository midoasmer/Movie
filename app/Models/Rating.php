<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public function movie()
    {
        return $this->belongsToMany(Movie::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

}
