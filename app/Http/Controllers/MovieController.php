<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatMovieRequest;
use App\Models\Actor;
use App\Models\Director;
use Illuminate\Http\Request;
use App\Models\Movie;
use DB;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();

        return  view('index',compact('movies')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Creat_Movie');
//        $name,$director_name,$actor_name,$description,$year
//        $movie = new Movie();
//        $movie->Name = $name;
//        $movie->Director_Name = $director_name;
//        $movie->Actor_name = $actor_name;
//        $movie->Description = $description;
//        $movie->Year = $year;
//        $movie->save();
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
//        $this->validate($request,[
//
//            'Name'          => 'required|unique:movies',
//            'Director_Name' =>  'required',
//            'Actor_Name'    =>  'required',
//            'Description'   =>  'required',
//            'Year'          =>  'required|integer',
//        ]);
         $movie = new Movie();
         $actor = new Actor();
         $director = new Director();
        $actor->Name = $request->Actor_Name;
        $director->Name = $request->Director_Name;
        $actor->save();
        $director->save();
        $movie->Name = $request->Name;
        $movie->Actor_Id = $request->Actor_Id;
        $movie->Director_Id = $request->Director_Id;
        $movie->Description = $request->Description;
        $movie->Year = $request->Year;
        $movie->save();
        return view('Creat_Movie');
    }

    /**
     * Display the specified resource.
     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $movie = DB :: select('select Description from movies where id = ?',[$id]);
        //$movie = new Movie();
        $movie =  Movie ::findOrfail ($id);
        return view('movies_show',compact('movie')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function edit($id)
    {
        $movie =  Movie ::findOrfail ($id);
        return view('Edite_Movie',compact('movie')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(CreatMovieRequest $request, $id)
    {
        $movie =  Movie ::findOrfail ($id);
        $movie->Name = $request->Name;
        $movie->Actor_Id = $request->Actor_Id;
        $movie->Director_Id = $request->Director_Id;
        $movie->Description = $request->Description;
        $movie->Year = $request->Year;
        $movie->save();
        return view('movies_show',compact('movie')) ;

    }

    /**
     * Remove the specified resource from storage.
     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Movie::where('id','=',$id)->delete();
        return redirect('/Movie');
    }
}
