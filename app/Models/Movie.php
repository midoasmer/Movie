<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Director_Name',
        'Actor_Name',
        'Description',
        'Year' ,
        'Image',
        'Rating',
        'Category_id'
    ];

    public function actor()
    {
        return $this->belongsTo(Actor::class,'Actor_Id', 'id');
    }

    public function director()
    {
        return $this->belongsTo(Director::class,'Director_Id', 'id');
    }

    public function photo()
    {

        return $this->belongsTo(Photo::class, 'Image', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_id', 'id');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
