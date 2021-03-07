<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UsersRequest;
use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::simplePaginate(5);

        return view('admin.users.index', compact('users'));
        // return $user->role->name;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(usersRequest $request)
    {
        // $user = new User();
        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['photo_id'] = $photo->id;
        } else {
            $request['photo_id'] = 'Non';
        }

//        $user->name = $request->name;
//        $user->role_id = $request->role_id;
//        $user->is_active = $request->is_active;
//        $user->email = $request->email;
//        $user->password = $request->password;
//        $user->save();
        $request['password'] = bcrypt($request->password);
        User::create($request->all());
        Session::flash('created_user',$request->name.' : has been created');
        return redirect('/admin/users');
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
        $user = User:: findOrfail($id);

        $roles = Role::all();
        return view('admin.users.edit', compact('user'), compact('roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserEditRequest $request, $id)
    {
        $user = User:: findOrfail($id);

        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $request['photo_id'] = $photo->id;
        }
        if (trim(($request->password) == '')) {
            $user->update($request->except('password'));
        } else {
            $request['password'] = bcrypt($request->password);
            $user->update($request->all());
        }

        Session::flash('updated_user',$request->name.' : has been updated');
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        $user = User:: findOrfail($id);;
        if($user->photo_id)
        {
            unlink(public_path().$user->photo->file);
            Photo::where('id','=',$user->photo_id)->delete();
        }
        User::findOrFail($id)->delete();
        Session::flash('deleted_user',$user->name.' : '.$user->role->name.' has been deleted');
        return redirect('/admin/users');
    }

//    public function delete(Request $request)
//    {
//        //User::where('id', '=', $id)->delete();
//        User::findOrFail($request->id)->delete();
//        Session::flash('deleted_user',$request->name.' : has been deleted');
//        return redirect('/admin/users');
//    }
}
