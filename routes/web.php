<?php

use Illuminate\Support\Facades\Route;
Use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "App\Http\Controllers\VisitorController@index");
Route::get('/all', "App\Http\Controllers\VisitorController@all_movie");
Route::get('/EditRating/{id}','App\Http\Controllers\RatingController@edit');
Route::get('/Rating','App\Http\Controllers\RatingController@RatingMovie');

Route::get('/SearchMovie', "App\Http\Controllers\SearchController@SearchMovie");
Route::get('/SearchActor', "App\Http\Controllers\SearchController@SearchActor");
Route::get('/Search/ShowMovie', 'App\Http\Controllers\SearchController@ShowMovie');
Route::get('/SearchActor/ShowActor', "App\Http\Controllers\SearchController@ShowActor");
//Route::get('/Search/Movie', "App\Http\Controllers\SearchController");
//Route::get('/Search/Movie', "App\Http\Controllers\SearchController");
//Route::resource('/Search',"App\Http\Controllers\MovieSearchController");

Route::group(['middleware'=>'login'],function (){

    Route::resource('/Movie',"App\Http\Controllers\MovieController");


//    Route::get('dates',function (){
//       $date = new DateTime('+1 week');
//       echo $date->format('d-m-y');
//
//       echo '<br>';
//
//       echo Carbon::now();
//    });
});


Route::group(['middleware'=>'admin'],function (){
    Route::resource('/Actor',"App\Http\Controllers\ActorController");
    Route::resource('/Director',"App\Http\Controllers\DirectorController");
    Route::resource('admin/users',"App\Http\Controllers\AdminUsersController");
    Route::delete('admin/users',"App\Http\Controllers\AdminUsersController@delete");
    Route::resource('/Category',"App\Http\Controllers\CategoryController");
});

//Route::resource('/Actor',"App\Http\Controllers\ActorController");
//Route::resource('/Director',"App\Http\Controllers\DirectorController");

//test route
Route::get('/test', function () {
    return view('testing');
});







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
