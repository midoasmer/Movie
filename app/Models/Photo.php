<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $uploads = '/images/';

    protected $fillable = [
        'file',
    ];
    use HasFactory;

    public function getFileAttribute($photo){
        return $this->uploads.$photo;
    }
}
