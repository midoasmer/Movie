<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatMovieRequest;
use App\Models\Actor;
use App\Models\Category;
use App\Models\Director;
use App\Models\Movie;
use App\Models\MovieActor;
use App\Models\Photo;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * //* @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $movies = Movie::simplePaginate(5);
        return view('index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * //* @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $directors = Director::all();
        $actors = Actor::all();
        return view('Creat_Movie', compact('actors'), compact('directors'))
            ->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param \Illuminate\Http\Request $request
     * //     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @return array
     */
    public function store(CreatMovieRequest $request)
    {

        //Cheich if the new movie have an photo
        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        } else {
            $request['Image'] = 'Non';
        }

        //int the rating value
        $request['Rating'] = '0';
        $movie = new Movie();
        //Store all data in new movie
        $movie->Name = $request->Name;
        $movie->Director_Id = $request->Director_Id;
        $movie->Actor_Id = $request->Actor0;
        $movie->Category_id = $request->Category0;
        $movie->Description = $request->Description;
        $movie->Year = $request->Year;
        $movie->Image = $request->Image;
        $movie->Rating = $request->Rating;
        $movie->save();
        DB::table('actor_movie')->insert([
            'movie_id' => $movie->id,
            'actor_id' => $request->Actor0
        ]);
        if (isset($request->Actor1)) {
            if ($request->Actor1 != $request->Actor0) {
                DB::table('actor_movie')->insert([
                    'movie_id' => $movie->id,
                    'actor_id' => $request->Actor1
                ]);
            }
        }
        if (isset($request->Actor2)) {
            if ($request->Actor2 != $request->Actor0 && $request->Actor2 != $request->Actor1) {
                DB::table('actor_movie')->insert([
                    'movie_id' => $movie->id,
                    'actor_id' => $request->Actor2
                ]);
            }
        }


        DB::table('category_movie')->insert([
            'movie_id' => $movie->id,
            'category_id' => $request->Category0
        ]);
        if (isset($request->Category1)) {
            if ($request->Category1 != $request->Category0) {
                DB::table('Category_movie')->insert([
                    'movie_id' => $movie->id,
                    'category_id' => $request->Category1
                ]);
            }
        }
        if (isset($request->Category2)) {
            if ($request->Category2 != $request->Category0 && $request->Category2 != $request->Category1) {
                DB::table('Category_movie')->insert([
                    'movie_id' => $movie->id,
                    'category_id' => $request->Category2
                ]);
            }
        }
        Session::flash('created_movie', $request->Name . ' : has been created');
        return redirect('/Movie');
    }

    /**
     * Display the specified resource.
     *
     * //     * @param int $id
     * //     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {

        $movie = Movie::findOrfail($id);
        $actor = Actor::findOrfail($movie->Actor_Id);
        $director = Director::findOrfail($movie->Director_Id);

        return view('movies_show', compact('movie'), compact('actor'))
            ->with(compact('director'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return string
     */
    public function edit($id)
    {
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
        //geting all actors ,directors and categories to display in list
        $directors = Director::all();
        $actors = Actor::all();
        $categories = Category::all();
        $movie = Movie::findOrfail($id);
        return view('Edite_Movie', compact('movie'), compact('actors'))
            ->with(compact('directors'))
            ->with(compact('categories'))
            ->with(compact('rate'))
            ->with(compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        //chick if the user delete all actors from movie or not
        if ($request->Actor0 === '0' &&
            ($request->Actor1 === '0' || !(isset($request->Actor1))) &&
            ($request->Actor2 === '0' || !(isset($request->Actor2)))) {

            Session::flash('updated_movie', $request->Name . ' : Can Not be update You Must Select One Actor At Lest');
            return redirect()->route('Movie.edit', ['Movie' => $id]);

        } else {
            if ($request->Category0 === '0' &&
                ($request->Category1 === '0' || !(isset($request->Category1))) &&
                ($request->Category2 === '0' || !(isset($request->Category2)))) {

                Session::flash('updated_movie', $request->Name . ' : Can Not be update You Must Select One Category At Lest');
                return redirect()->route('Movie.edit', ['Movie' => $id]);

            } else {
                $movie = Movie::findOrfail($id);
                $user = Auth::user();
                //check if the movie have photo or not
                if ($movie->Image === 'Non') {
                    //if movie dont have photo check if the user add photo or not
                    if ($file = $request->file('image')) {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('images', $name);
                        $photo = Photo::create(['file' => $name]);
                        $request['Image'] = $photo->id;
                        $movie->update([
                            'Image' => $photo->id,
                        ]);
                    }
                } //if movie have photo check if the user edit the photo or not
                else {
                    if ($file = $request->file('image')) {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('images', $name);
                        $photo = Photo::findOrfail($movie->Image);
                        unlink(public_path() . $photo->file);
                        $photo->update([
                            'file' => $name,
                        ]);
                    }
                }
                //check if user select rate or not
                if ($request->Rate !== "No Rate") {
                    //check if the user had rated this movie before or not
                    if ($check = Rating::where('movie_id', $movie->id)->where('user_id', $user->id)->exists()) {
                        Rating::where('movie_id', $movie->id)
                            ->where('user_id', $user->id)
                            ->update([
                                'rate' => $request->Rate,
                                'Review' => $request->Review
                            ]);
                        //function to sum the new rate (the function in the end of controller)
                        $newRate = $this->newRate($movie->id);
                    } else {
                        $rate = new Rating();
                        $rate->movie_id = $movie->id;
                        $rate->user_id = $user->id;
                        $rate->rate = $request->Rate;
                        if ($request->filled('Review')) {
                            $rate->review = $request->Review;
                        } else {
                            $rate->review = "No Review";
                        }
                        $rate->save();
                        $newRate = $this->newRate($movie->id);
                    }
                } else {
                    $newRate = $movie->Rating;
                }
                $movie->update([
                    'Name' => $request->Name,
                    'Director_Id' => $request->Director_Id,
                    'Actor_Id' => $request->Actor0,
                    'Description' => $request->Description,
                    'Category_id' => $request->Category0,
                    'Year' => $request->Year,
                    'Rating' => $newRate
                ]);
                DB::table('actor_movie')->where('movie_id', '=', $id)->delete();
                if ($request->Actor0 != '0') {
                    DB::table('actor_movie')->insert([
                        'movie_id' => $movie->id,
                        'actor_id' => $request->Actor0
                    ]);
                }
                if (isset($request->Actor1)) {
                    if ($request->Actor1 != $request->Actor0 && $request->Actor1 != '0') {
                        DB::table('actor_movie')->insert([
                            'movie_id' => $movie->id,
                            'actor_id' => $request->Actor1
                        ]);

                    }
                }
                if (isset($request->Actor2)) {
                    if ($request->Actor2 != $request->Actor0 && $request->Actor2 != $request->Actor1
                        && $request->Actor2 != '0') {
                        DB::table('actor_movie')->insert([
                            'movie_id' => $movie->id,
                            'actor_id' => $request->Actor2
                        ]);
                    }
                }
                DB::table('category_movie')->where('movie_id', '=', $id)->delete();
                if ($request->Category0 != '0') {
                    DB::table('category_movie')->insert([
                        'movie_id' => $movie->id,
                        'category_id' => $request->Category0
                    ]);
                }
                if (isset($request->Category1)) {
                    if ($request->Category1 != $request->Category0 && $request->Category1 != '0') {
                        DB::table('category_movie')->insert([
                            'movie_id' => $movie->id,
                            'category_id' => $request->Category1
                        ]);

                    }
                }
                if (isset($request->Category)) {
                    if ($request->Category2 != $request->Category0 && $request->Category2 != $request->Category1
                        && $request->Category2 != '0') {
                        DB::table('category_movie')->insert([
                            'movie_id' => $movie->id,
                            'category_id' => $request->Category2
                        ]);
                    }
                }
                Session::flash('updated_movie', $request->Name . ' : has been updated');
                return redirect('/Movie');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * //     * @param int $id
     * //     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $movie = Movie::findOrfail($id);
        if (isset($movie->Image) && $movie->Image != "Non") {
            unlink(public_path() . $movie->photo->file);
            Photo::where('id', '=', $movie->Image)->delete();
        }
        Movie::where('id', '=', $id)->delete();
        Rating::where('movie_id', '=', $id)->delete();
        DB::table('actor_movie')->where('movie_id', '=', $id)->delete();
        Session::flash('deleted_movie', $movie->Name . ' : Movie has been deleted');
        return redirect('/Movie');
    }

    public function newRate($movie_id)
    {
        $sum = Rating::where('movie_id', $movie_id)->sum('rate');
        $count = Rating::where('movie_id', $movie_id)->count();
        $rate = $sum / $count;
        return number_format((float)$rate, 1, '.', '');;
    }
}
