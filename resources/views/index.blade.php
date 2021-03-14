@extends('App')

@section('content')
    @if(Session::has('created_movie'))
        <p class="bg-danger">{{session('created_movie')}}</p>
    @endif

    @if(Session::has('updated_movie'))
        <p class="bg-danger">{{session('updated_movie')}}</p>
    @endif

    @if(Session::has('deleted_movie'))
        <p class="bg-danger">{{session('deleted_movie')}}</p>
    @endif
    @csrf
    {{--        <ul>--}}
    {{--            @foreach($movies as $movie)--}}
    {{--                <li><a href="{{route('Movie.show',$movie->id)}}"> {{$movie->Name}}</a></li><br>--}}
    {{--               <form method="GET" action="/Movie/{{$movie->id}}/edit">--}}
    {{--                <input type="submit" value="Update">--}}
    {{--                </form>--}}

    {{--                {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\MovieController@destroy',$movie->id]]) !!}--}}
    {{--                {!! Form::submit('Delete Movie',['class'=>'btn btn-danger']) !!}--}}
    {{--                {!! Form:: close() !!}--}}
    {{--            @endforeach--}}

    {{--        </ul>--}}

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Movie Name</th>
            <th>Actor Name</th>
            <th>Director Name</th>
            <th> Category</th>
            <th>Description</th>
            <th>Year</th>
            <th>Rate</th>
            @if(Auth::check())
                <th>Rating</th>
                @if(Auth::user()->isAdmin())
                    <th>UpDate</th>
                    <th>Delete</th>
                @endif
            @endif
        </tr>
        </thead>
        <tbody>

        @foreach($movies as $movie)
            <tr>
                <td>{{$movie->id}}</td>
                <td><img height="50" src="{{$movie->photo ? $movie->photo->file :'http://placehold.it/50x50'}}"></td>
                <td>{{$movie->Name}}</td>
                <td>
                    @foreach ($movie->actors as $act)
                        {{$act->Name}}
                        <br>
                    @endforeach
                </td>
                <td>{{$movie->director->Name}}</td>
                <td>
                    @foreach ($movie->categories as $cat)
                        {{$cat->Name}}
                        <br>
                    @endforeach
                </td>
                <td>{{$movie->Description}}</td>
                <td>{{$movie->Year}}</td>
                <td>{{$movie->Rating}}</td>
                @if(Auth::check())
                    <td>
                        <form method="GET" action="/EditRating/{{$movie->id}}">
                            <input type="submit" value="Rate">
                        </form>
                    </td>
                    @if(Auth::user()->isAdmin())
                        <td>
                            <form method="GET" action="/Movie/{{$movie->id}}/edit">
                                <input type="submit" value="Update" class='btn btn-primary'>
                            </form>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\MovieController@destroy',$movie->id]]) !!}
                            {!! Form::submit('Delete Movie',['class'=>'btn btn-danger']) !!}
                            {!! Form:: close() !!}
                        </td>
                    @endif
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $movies->links() }}
@endsection

