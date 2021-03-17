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
        $categories = Category::all();
        return view('Movie_Search', compact('actors'), compact('directors'))
            ->with(compact('categories'));
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
        $categories = Category::all();
        //if user search by just year
        if ($request->Actor_Id === '0' && $request->Director_Id === '0' && $request->Category === '0') {
            $movies = Movie::whereBetween('Year', [$request->StartYear, $request->EndYear])->get();
            $actor_id = $request->Actor_Id;
            $actor_name = 'Select Actor';
            $director_id = $request->Director_Id;
            $director_name = 'Select Director';
            $category_id = $request->Category;
            $category_name = 'Select Category';
            $t = Movie::whereBetween('Year', [$request->StartYear, $request->EndYear])->count();
        }//if user search by year and director
        elseif ($request->Actor_Id === '0' && $request->Category === '0') {
            $movies = Movie::where('Director_id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->get();
            $actor_id = $request->Actor_Id;
            $actor_name = 'Select Actor';
            $dir = Director::findOrFail($request->Director_Id);
            $director_id = $dir->id;
            $director_name = $dir->Name;
            $category_id = $request->Category;
            $category_name = 'Select Category';
            $t = Movie::where('Director_id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();
        }//if user search by year and actor
        elseif ($request->Director_Id === '0' && $request->Category === '0') {
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
            $category_id = $request->Category;
            $category_name = 'Select Category';
            $t = Movie::findOrFail($arr)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();
        }//if user search by year and category
        elseif ($request->Director_Id === '0' && $request->Actor_Id === '0') {
            $ids = DB::table('category_movie')
                ->where('category_id', '=', $request->Category)
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
            $cat = Category::findOrFail($request->Category);
            $category_id = $cat->id;
            $category_name = $cat->Name;
            $actor_id = $request->Actor_Id;
            $actor_name = 'Select Actor';
            $director_id = $request->Director_Id;
            $director_name = 'Select Director';
            $t = Movie::findOrFail($arr)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();
        }//if use search by director, category and year
        elseif ($request->Actor_Id === '0') {
            $ids = DB::table('category_movie')
                ->where('category_id', '=', $request->Category)
                ->get(['movie_id']);
            $arr = array();
            $qq = 0;
            //convert collection to array
            foreach ($ids as $id) {
                $arr[$qq] = $id->movie_id;
                $qq++;
            }
            $movies = Movie::findOrFail($arr)
                ->where('Director_Id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear]);
            $cat = Category::findOrFail($request->Category);
            $dir = Director::findOrFail($request->Director_Id);
            $actor_id = $request->Actor_Id;
            $actor_name = 'Select Actor';
            $director_id = $dir->id;
            $director_name = $dir->Name;
            $category_id = $cat->id;
            $category_name = $cat->Name;
            $t = Movie::findOrFail($arr)
                ->where('Director_Id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();

        }//if use search by actor, category and year
        elseif ($request->Director_Id === '0') {
            $ids = DB::table('actor_movie')
                ->where('actor_id', '=', $request->Actor_Id)
                ->get(['movie_id']);
            $arr = array();
            $qq = 0;
            foreach ($ids as $id) {
                $arr[$qq] = $id->movie_id;
                $qq++;
            }
            $arr2 = array();
            $qq2 = 0;
            $q1=0;
            //this loop to chick for evry movie for selected actor if in the same category or not
            foreach ($arr as $id2) {
                //to chick if this id have a record or not
                $chick=DB::table('category_movie')
                    ->where('category_id', '=', $request->Category)
                    ->where('movie_id', '=', $arr[$q1])->count();
                if($chick > 0){
                    //if have a record get it
                    $arr2[$qq2]=$arr[$q1];
                    $qq2++;
                }
                $q1++;
            }

            $movies = Movie::findOrFail($arr2)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear]);
            $act = Actor::findOrFail($request->Actor_Id);
            $cat = Category::findOrFail($request->Category);
            $actor_id = $act->id;
            $actor_name = $act->Name;
            $director_id = $request->Director_Id;
            $director_name = 'Select Director';
            $category_id = $cat->id;
            $category_name = $cat->Name;
            $t = Movie::findOrFail($arr2)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();

        }//if use search by director, actor and year
        elseif ($request->Category === '0') {
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
            $category_id = $request->Category;
            $category_name = 'Select Category';
            $t = Movie::findOrFail($arr)
                ->where('Director_Id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();

        }//if user search by director, category,actor and year
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
            $arr2 = array();
            $qq2 = 0;
            $q1=0;
            //this loop to chick for evry movie for selected actor if in the same category or not
            foreach ($arr as $id2) {
                //to chick if this id have a record or not
                $chick=DB::table('category_movie')
                    ->where('category_id', '=', $request->Category)
                    ->where('movie_id', '=', $arr[$q1])->count();
               if($chick > 0){
                     //if have a record get it
                   $arr2[$qq2]=$arr[$q1];
                   $qq2++;
               }
               $q1++;
            }

            $movies = Movie::findOrFail($arr2)
                ->where('Director_Id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear]);
            $act = Actor::findOrFail($request->Actor_Id);
            $dir = Director::findOrFail($request->Director_Id);
            $cat = Category::findOrFail($request->Category);
            $actor_id = $act->id;
            $actor_name = $act->Name;
            $director_id = $dir->id;
            $director_name = $dir->Name;
            $category_id = $cat->id;
            $category_name = $cat->Name;
            $t = Movie::findOrFail($arr2)
                ->where('Director_Id', '=', $request->Director_Id)
                ->whereBetween('Year', [$request->StartYear, $request->EndYear])->count();
        }
        $startyear = $request->StartYear;
        $endyear = $request->EndYear;
        return view('Required_Movie', compact('movies'))
            ->with(compact('t'))
            ->with(compact('directors'))
            ->with(compact('actors'))
            ->with(compact('categories'))
            ->with(compact('actor_id'))
            ->with(compact('actor_name'))
            ->with(compact('director_id'))
            ->with(compact('director_name'))
            ->with(compact('category_id'))
            ->with(compact('category_name'))
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
