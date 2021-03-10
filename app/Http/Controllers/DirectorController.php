<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\Movie;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\CreatDirectorRequest;
use Illuminate\Support\Facades\Session;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $directors = Director::simplePaginate(5);

        return view('Index_Director', compact('directors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('Create_Director');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreatDirectorRequest $request)
    {
        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        } else {
            $request['Image'] = 'Non';
        }
        Director::create($request->all());
//        $director = new Director();
//
//        if ($file = $request->file('image')) {
//
//            $request['Image'] = $file->getClientOriginalName();
//            $file->move('images', $request->Image);
//            $director->Image = $request->Image;
//        } else {
//            $director->Image = 'Non';
//        }
//
//        $director->Name = $request->Name;
//        $director->birthdate = $request->birthdate;
//        $director->gender = $request->gender;
//        $director->save();
        Session::flash('created_director', $request->Name . ' : has been created');
        return redirect('/Director');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $director = Director::findOrfail($id);
        return view('Show_Director', compact('director'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $director = Director::findOrfail($id);
        return view('Edite_Director', compact('director'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(CreatDirectorRequest $request, $id)
    {
        $director = Director::findOrfail($id);

        if ($file = $request->file('image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['Image'] = $photo->id;
        }
        $director->update($request->all());
//
//        if ($file = $request->file('image')) {
//
//            $request['Image'] = $file->getClientOriginalName();
//            $file->move('images', $request->Image);
//            $director->Image = $request->Image;
//        }
//
//        $director->Name = $request->Name;
//        $director->birthdate = $request->birthdate;
//        $director->gender = $request->gender;
//        $director->save();
        Session::flash('updated_director', $request->Name . ' : has been updated');
        return redirect('/Director');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $director = Director::findOrfail($id);
        if ($movie = Movie::where('Director_Id', '=', $id)->exists()) {
            Session::flash('deleted_director', $director->Name . ' : There is a Movies Have This Directors So Can not Delete it');
            return redirect('/Director');
        } else {
            if ($director->Image) {
                unlink(public_path() . $director->photo->file);
                Photo::where('id', '=', $director->Image)->delete();
            }
            Director::where('id', '=', $id)->delete();
            Session::flash('deleted_director', $director->Name . ' : Director has been deleted');
            return redirect('/Director');
        }
    }
}
