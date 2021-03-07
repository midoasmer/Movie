<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    //
    public function SearchMovie()
    {
        $directors = Director::all();
        $actors = Actor::all();
        return view('Movie_Search', compact('actors'), compact('directors'));
    }

    public function SearchActor()
    {
        $movies = Movie::all();
        $categories = Category::all();

        return view('Actor_Search', compact('movies'), compact('categories'));;
    }

    public function ShowMovie(Request $request)
    {

//        $movies[] = Movie::where(['Actor_Id'=> $request->Actor_id,'Director_id'=>$request->Director_Id])->get();
//        dd($movies);
        $directors = Director::all();
        $actors = Actor::all();
        $movies = Movie::where('Actor_ID', '=', $request->Actor_Id)
            ->where('Director_id', '=', $request->Director_Id)
            ->whereBetween('Year', [$request->EndYear, $request->StartYear])->simplePaginate(5);
        //$movies = $movies->simplePaginate(2);
        $actor = Actor::findOrfail($request->Actor_Id);
        $director = Director::findOrfail($request->Director_Id);
        $startyear = $request->StartYear;
        $endyear = $request->EndYear;
        return view('Required_Movie', compact('movies'))
            ->with(compact('directors'))
            ->with(compact('actors'))
            ->with(compact('startyear'))
            ->with(compact('endyear'));
    }
    public function ShowActor(Request $request)
    {
        $movies = Movie::all();
        $categories = Category::all();
        if ($request->Movie_Id === 'Non' && $request->Category_Id === 'Non') {
            Session::flash('select', 'Select On Option');
            return redirect('/SearchActor');
        }

        if ($request->Movie_Id != 'Non' && $request->Category_Id != 'Non') {
            Session::flash('select', 'Select On Option');
            return redirect('/SearchActor');
        }

        if ($request->Movie_Id != "Non") {
            $movier = Movie::findOrfail($request->Movie_Id);
            $actors = 'Non';
            return view('Rcquired_Actor', compact('movier'))->with(compact('movies'))
                ->with(compact('categories'))
                ->with(compact('actors'));
        }

        if ($request->Category_Id != "Non") {
            $movier='Non';
            $categore= Category::findOrfail($request->Category_Id);
            $movies = DB::table('movies')
                ->where('Category_id', '=', $request->Category_Id);
            $movies = $movies->get();
            $actors = [];
            $i = 0;
            foreach ($movies as $movie) {
                $actorr = Actor::findOrfail($movie->Actor_Id);
                foreach ($actors as $actor) {
                    if ($actor === $actorr->Name) {
                        goto A;
                    }
                }
                $actors[$i] =$actorr->Name;
                $i++;
                A:;
            }
            //$actors = $this->paginate($actors);
            return view('Rcquired_Actor', compact('actors'))->with(compact('movies'))
                ->with(compact('categories'))
                ->with(compact('movier'))
                ->with(compact('categore'));
        }
    }

    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
