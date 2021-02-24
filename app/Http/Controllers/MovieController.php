<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatMovieRequest;
use App\Models\Actor;
use App\Models\Category;
use App\Models\Director;
use App\Models\Movie;
use App\Models\Photo;
use App\Models\Rating;
use Illuminate\Http\Request;
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
        $rate = new Rating();
        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        } else {
            $request['Image'] = 'Non';
        }
       // $request['Category_id']->$request->Category_id;
        $request['Rating'] = '0';
        $movie = Movie::create($request->all());
        $rate->movie_id = $movie->id;
        $rate->rate = '0';
        $rate->number_of_rated_users = '0';
        $rate->save();
        $rate = Rating::where('movie_id', $movie->id)->get();
        $request->Rating = $rate[0]->id;
        $movie->Director_Id = $request->Director_Id;
        $movie->Actor_Id = $request->Actor_Id;
        $movie->Rating = $request->Rating;
        $movie->save();

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

        return view('movies_show', compact('movie'), compact('actor'))->with(compact('director'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return string
     */
    public function edit($id)
    {
        $directors = Director::all();
        $actors = Actor::all();
        $movie = Movie::findOrfail($id);
        return view('Edite_Movie', compact('movie'), compact('actors'))->with(compact('directors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return string
     */
    public function update(CreatMovieRequest $request, $id)
    {
        $movie = Movie::findOrfail($id);

        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        }
        $rate = Rating::where('movie_id', $movie->id)->get();
        $users = $rate[0]->number_of_rated_users + 1;
        $newrate = (double)($rate[0]->rate + (double)$request->Rate) / (double)$users;
        $newrate = number_format((float)$newrate, 1, '.', '');
        $this->newRate($rate[0]->id, $newrate, $users);
        $movie->update($request->all());
//        if ($file = $request->file('image')) {
//
//            $request['Image'] = $file->getClientOriginalName();
//            $file->move('images', $request->Image);
//            $movie->Image = $request->Image;
//        }
//
//        $movie->Name = $request->Name;
//        $movie->Actor_Id = $request->Actor_Id;
//        $movie->Director_Id = $request->Director_Id;
//        $movie->Description = $request->Description;
//        $movie->Year = $request->Year;
//        $movie->save();
//        $id=$movie->id;
        Session::flash('updated_movie', $request->Name . ' : has been updated');
        return redirect('/Movie');

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
        if ($movie->Image) {
            Photo::where('id', '=', $movie->Image)->delete();
        }
        Movie::where('id', '=', $id)->delete();
        Rating::where('movie_id', '=', $id)->delete();
        Session::flash('deleted_movie', $movie->Name . ' : Movie has been deleted');
        return redirect('/Movie');
    }

    public function newRate($id, $rate, $users)
    {

        //$movie = Movie::findOrfail($id);
        Rating::where('id', $id)->update(['rate' => $rate, 'number_of_rated_users' => $users]);
    }
}
