<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function actor()
    {
        return $this->hasMany('App\Models\Actor');
    }

    public function director()
    {
        return $this->hasMany('App\Models\Director');
    }


}
