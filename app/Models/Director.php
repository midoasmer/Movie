<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'birthdate',
        'gender',
        'Image'
    ];

    public function movie()
    {
        return $this->hasMany(Movie::class);
    }

    public function photo()
    {

        return $this->belongsTo(Photo::class, 'Image', 'id');
    }
}
