<?php

namespace App\Http\Controllers;


use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RatingController extends Controller
{
    public function edit($id)
    {
        $movie = Movie::findOrfail($id);
        $user = Auth::user();
        // geting user rate to display
        if ($check = Rating::where('movie_id', $id)->where('user_id', $user->id)->exists()) {
            $rate = Rating::where('movie_id', $id)
                ->where('user_id', $user->id)
                ->first();
            $review = $rate->review;
            $rate = $rate->rate;
        } else {
            $rate = "Not Rated";
            $review = "No Review";
        }
        return view('Rating', compact("movie"))
            ->with(compact('rate'))
            ->with(compact('review'));
    }

    public function RatingMovie(Request $request)
    {
        $user = Auth::user();
        $movie = Movie::findOrfail($request->movie_id);
        if ($request->Rate !== "No Rate") {
            //check if the user had rated this movie before or not
            if ($check = Rating::where('movie_id', $request->movie_id)->where('user_id', $user->id)->exists()) {
                Rating::where('movie_id', $request->movie_id)
                    ->where('user_id', $user->id)
                    ->update([
                        'rate' => $request->Rate,
                        'Review' => $request->Review
                    ]);
                //function to sum the new rate
                $newRate = $this->newRate($request->movie_id);
            } else {
                $rate = new Rating();
                $rate->movie_id = $request->movie_id;
                $rate->user_id = $user->id;
                $rate->rate = $request->Rate;
                if ($request->filled('Review')) {
                    $rate->review = $request->Review;
                } else {
                    $rate->review = "No Review";
                }
                $rate->save();
                $newRate = $this->newRate($request->movie_id);
            }
            // this if user rated the movie before and did't change it
        } else {
            $newRate = $movie->Rating;
        }
        $movie->update([
            'Rating' => $newRate
        ]);
        Session::flash('updated_movie', $movie->Name . ' : has been updated The rate');
        return redirect('/Movie');
    }

    public function newRate($movie_id)
    {
        $sum = Rating::where('movie_id', $movie_id)->sum('rate');
        $count = Rating::where('movie_id', $movie_id)->count();
        $rate = $sum / $count;
        return number_format((float)$rate, 1, '.', '');
    }
}
