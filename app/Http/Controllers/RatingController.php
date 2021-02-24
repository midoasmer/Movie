<?php

namespace App\Http\Controllers;


use App\Models\Movie;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function RatingMovie($movie_id,$rate)
    {
      return $movie_id.'   '.$rate;
    }
}
