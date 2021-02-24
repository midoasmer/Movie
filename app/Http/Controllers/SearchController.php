<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
    public function Search()
    {
        $directors = Director::all();
        $actors = Actor::all();
        return view('Movie_Search', compact('actors'), compact('directors'));
    }

    public function show(Request $request)
    {

//        $movies[] = Movie::where(['Actor_Id'=> $request->Actor_id,'Director_id'=>$request->Director_Id])->get();
//        dd($movies);
        $directors = Director::all();
        $actors = Actor::all();
        $movies = DB::table('movies')->where('Actor_ID','=',$request->Actor_Id)
        ->where('Director_id','=',$request->Director_Id)
        ->whereBetween('Year',[$request->EndYear,$request->StartYear]);
        $movies = $movies->simplePaginate(2);
        $actor = Actor::findOrfail($request->Actor_Id);
        $director = Director::findOrfail($request->Director_Id);
        $startyear = $request->StartYear;
        $endyear = $request->EndYear;
//        $movies[] = new Movie();
//        $movies=$allmovies;
        return view('Required_Movie',compact('movies'),compact('actor'))
            ->with(compact('director'))
            ->with(compact('directors'))
            ->with(compact('actors'))
            ->with(compact('startyear'))
            ->with(compact('endyear'));
    }
}
