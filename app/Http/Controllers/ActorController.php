<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Movie;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\CreatActorRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $actors = Actor::simplePaginate(5);
       // $actors = Actor::all();

        return view('Index_Actor', compact('actors'));
       // return view('testing', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('Create_Actor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreatActorRequest $request)
    {


        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        } else {
            $request['Image'] = 'Non';
        }
        Actor::create($request->all());
        // $actor = new Actor();
//        if ($file = $request->file('image')) {
//
//            $request['Image'] = $file->getClientOriginalName();
//            $file->move('images', $request->Image);
//            $actor->Image = $request->Image;
//        } else {
//            $actor->Image = 'Non';
//        }

//        $actor->Name = $request->Name;
//        $actor->birthdate = $request->birthdate;
//        $actor->gender = $request->gender;
//        $actor->save();
        Session::flash('created_actor',$request->Name.' : has been created');
        return redirect('/Actor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $actor =  Actor ::findOrfail ($id);
        return view('Show_Actor',compact('actor')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $actor = Actor::findOrfail($id);
        return view('Edite_Actor', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(CreatActorRequest $request, $id)
    {
        $actor = Actor::findOrfail($id);

        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        }
        $actor->update($request->all());

//        if ($file = $request->file('image')) {
//
//            $request['Image'] = $file->getClientOriginalName();
//            $file->move('images', $request->Image);
//            $actor->Image = $request->Image;
//        }
//
//        $actor->Name = $request->Name;
//        $actor->birthdate = $request->birthdate;
//        $actor->gender = $request->gender;
//        $actor->save();
        Session::flash('updated_actor',$request->Name.' : has been updated');
        return redirect('/Actor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $actor = Actor::findOrfail($id);
        if (DB::table('actor_movie')->where('actor_id', '=', $id)->exists()) {
            Session::flash('deleted_actor', $actor->Name . ' : There is a Movies Have This Actor So Can not Delete it');
            return redirect('/Actor');
        } else {
            if ($actor->Image) {
                unlink(public_path() . $actor->photo->file);
                Photo::where('id', '=', $actor->Image)->delete();
            }
            Actor::where('id', '=', $id)->delete();
            Session::flash('deleted_actor', $actor->Name . ' : Actor has been deleted');
            return redirect('/Actor');
        }
    }
}
