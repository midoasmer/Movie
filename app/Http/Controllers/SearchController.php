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
        $directors = Director::all();
        $actors = Actor::all();
        //if user search by just year
        if ($request->Actor_Id === '0' && $request->Director_Id === '0') {
            $movies = Movie::whereBetween('Year', [$request->StartYear, $request->EndYear])->simplePaginate(5);
            $actor_id = $request->Actor_Id;
            $actor_name = 'Selectb Actor';
            $director_id = $request->Director_Id;
            $director_name = 'Select Director';
        }//if user search by year and director
        elseif ($request->Actor_Id === '0') {
            $movies = Movie::where('Director_id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->simplePaginate(5);
            $actor_id = $request->Actor_Id;
            $actor_name = 'Selectb Actor';
            $dir = Director::findOrFail($request->Director_Id);
            $director_id = $dir->id;
            $director_name = $dir->Name;
        }//if user search by year and actor
        elseif ($request->Director_Id === '0') {
            //get movies id from actor_movie table for the selected actor
            $ids = DB::table('actor_movie')
                ->where('actor_id', '=', $request->Actor_Id)
                ->get(['movie_id']);
            $arr = array();
            $qq = 0;
            //convert collection to array
            foreach ($ids as $id) {
                $arr[$qq] = $id->movie_id;
                $qq++;
            }
            $movies = Movie::findOrFail($arr)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear]);
            $act = Actor::findOrFail($request->Actor_Id);
            $actor_id = $act->id;
            $actor_name = $act->Name;
            $director_id = $request->Director_Id;
            $director_name = 'Select Director';
        }//if user search by year and director and director
        else {
            $ids = DB::table('actor_movie')
                ->where('actor_id', '=', $request->Actor_Id)
                ->get(['movie_id']);
            $arr = array();
            $qq = 0;
            foreach ($ids as $id) {
                $arr[$qq] = $id->movie_id;
                $qq++;
            }
            $movies = Movie::findOrFail($arr)
                ->where('Director_Id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear]);
            $act = Actor::findOrFail($request->Actor_Id);
            $dir = Director::findOrFail($request->Director_Id);
            $actor_id = $act->id;
            $actor_name = $act->Name;
            $director_id = $dir->id;
            $director_name = $dir->Name;
        }
        $startyear = $request->StartYear;
        $endyear = $request->EndYear;
        return view('Required_Movie', compact('movies'))
            ->with(compact('directors'))
            ->with(compact('actors'))
            ->with(compact('actor_id'))
            ->with(compact('actor_name'))
            ->with(compact('director_id'))
            ->with(compact('director_name'))
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
            $movier = 'Non';
            $categore = Category::findOrfail($request->Category_Id);
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
                $actors[$i] = $actorr->Name;
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
