@extends('App')

@section('content')
    @csrf
    @if(Session::has('created_director'))
        <p class="bg-danger">{{session('created_director')}}</p>
    @endif

    @if(Session::has('updated_director'))
        <p class="bg-danger">{{session('updated_director')}}</p>
    @endif

    @if(Session::has('deleted_director'))
        <p class="bg-danger">{{session('deleted_director')}}</p>
    @endif

    <h1>Directors</h1>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Date Of Birth</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $directors as $director)
            <tr>
                <td>{{$director->id}}</td>
                <td><img height="50" src="{{$director->photo ? $director->photo->file :'http://placehold.it/50x50'}}">
                </td>
                <td>{{$director->Name}}</td>
                <td>{{$director->gender}}</td>
                <td>{{$director->birthdate}}</td>
                <td>{{$director->created_at->diffForHumans()}}</td>
                <td>{{$director->updated_at->diffForHumans()}}</td>
                <td>
                    <form method="GET" action="/Director/{{$director->id}}/edit">
                        <input type="submit" value="Update">
                    </form>
                </td>
                <td>
                    {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\DirectorController@destroy',$director->id]]) !!}
                    {!! Form::submit('Delete Director',['class'=>'btn btn-danger']) !!}
                    {!! Form:: close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $directors->links() }}
@endsection

{{--<select>--}}
{{--    @foreach ($levels as $level)--}}
{{--        <option value="{{ $level->id }}">{{ $level->name }}</option>--}}
{{--    @endforeach--}}
{{--</select>--}}
