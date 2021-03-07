<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::simplePaginate(5);;

        return view('Index_Category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('Creat_Category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|unique:categories|max:255',
        ]);

        $category = new Category();
        $category->Name = $request->Name;
        $category->save();
        Session::flash('created_category', $request->Name . ' : has been created');
        return redirect('/Category');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $category = Category::findOrfail($id);
        return view('Edit_Category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|unique:categories|max:255',
        ]);
        $category = Category::findOrfail($id);
        $category->Name = $request->Name;
        $category->update();
        Session::flash('updated_category', $request->Name . ' : has been updated');
        return redirect('/Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $category = Category::findOrfail($id);
        if ($movie = Movie::where('Category_id', '=', $id)->exists()) {
            Session::flash('cant_delete', $category->Name . ' : There is a Movies Have This Category So Can not Delete it');
            return redirect('/Category');
        } else {
            $category = Category::findOrfail($id);
            Category::where('id', '=', $id)->delete();
            Session::flash('deleted_category', $category->Name . ' : Category has been deleted');
            return redirect('/Category');
        }
    }
}
