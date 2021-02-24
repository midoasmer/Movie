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
Route::get('/Rating/{movie_id}/{id}','App\Http\Controllers\RatingController@RatingMovie');

Route::get('/Search', "App\Http\Controllers\SearchController@Search");
Route::get('/Search/show', 'App\Http\Controllers\SearchController@show');
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
Route::get('/Categor', function () {
    return view('Creat_Category');
});







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
