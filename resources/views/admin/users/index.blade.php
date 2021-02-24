@extends('App')


@section('content')

    @if(Session::has('created_user'))
        <p class = "bg-danger">{{session('created_user')}}</p>
    @endif

    @if(Session::has('updated_user'))
        <p class = "bg-danger">{{session('updated_user')}}</p>
    @endif

    @if(Session::has('deleted_user'))
    <p class = "bg-danger">{{session('deleted_user')}}</p>
    @endif

    <h1>Users</h1>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>

        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><img height="50" src="{{$user->photo ? $user->photo->file :'http://placehold.it/50x50'}}"></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>{{$user->is_active == 1 ? 'Active' : 'Not Active'}}</td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>{{$user->updated_at->diffForHumans()}}</td>
                    <td>
                        <form method="GET" action="/admin/users/{{$user->id}}/edit">
                            <input type="submit" value="Update">
                        </form>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\AdminUsersController@destroy',$user->id]]) !!}
                        {!! Form::submit('Delete User',['class'=>'btn btn-danger']) !!}
                        {!! Form:: close() !!}
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
