@extends('App')

@section('content')
    <h1>Movies Search</h1>
    @csrf
    <ul>
        {!! Form::open(array('method'=>'GET','action'=>'App\Http\Controllers\SearchController@ShowMovie')) !!}
        <table style="width:100%">
            <tr>
                <th>Actor Name</th>
                <th>Director Name</th>
                <th>Category</th>
                <th>From</th>
                <th>To</th>
            </tr>
            <tr>
                <th>
                    <select name="Actor_Id" class="form-control">
                        <option value="{{$actor_id}}">{{$actor_name}}</option>
                        <option value="0">Select Actor</option>
                        @foreach ($actors as $actor1)
                            <option value="{{$actor1->id}}">{{$actor1->Name}}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select name="Director_Id" class="form-control">
                        <option value="{{$director_id}}">{{$director_name}}</option>
                        <option value="0">Select Director</option>
                        @foreach ($directors as $director1)
                            <option value="{{$director1->id}}">{{$director1->Name}}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select name="Category" class="form-control">
                        <option value="{{$category_id}}">{{$category_name}}</option>
                        <option value="0">Select Category</option>
                        @foreach ($categories as $category1)
                            <option value="{{$category1->id}}">{{$category1->Name}}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select id="StartYear" name="StartYear" class="form-control">
                        <option value="{{ $startyear }}">{{ $startyear }}</option>
                        {{ $last= date('Y')-80 }}
                        {{ $now = date('Y') }}
                        @for ($i = $last; $i <= $now; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </th>
                <th>
                    <select id="EndYear" name="EndYear" class="form-control">
                        <option value="{{$endyear}}">{{$endyear}}</option>
                        {{ $last= date('Y')-80 }}
                        {{ $now = date('Y') }}
                        @for ($i = $now; $i >= $last; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </th>
            </tr>
        </table>
        <br>
        {!! Form::submit('Search Movies',['class'=>'btn btn-primary']) !!}
        {!! Form:: close() !!}
        <br>
        @if(!Auth::check())
            {!! Form::open(['method'=>'GET','action'=>['App\Http\Controllers\VisitorController@all_movie']]) !!}
            {!! Form::submit('All Movies',['class'=>'btn btn-primary']) !!}
            {!! Form:: close() !!}
        @endif

        {{--        -----------------------------------------------------------------------------------------------------------------}}
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
            @if($t===0)
            No Movie Founded
            @else
                {{$t}}    Movie Founded
            @foreach($movies as $movie)
                <tr>
                    <td>{{$movie->id}}</td>
                    <td><img height="50" src="{{$movie->photo ? $movie->photo->file :'http://placehold.it/50x50'}}">
                    </td>
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
                                    <input type="submit" value="Update">
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
            @endif
            </tbody>
        </table>
        {{--                    {{ $movies->links() }}--}}
        {{--        {!! $movies->appends(Request::all())->links() !!}--}}
        {{--                {!! $movies->render() !!}--}}
    </ul>

@endsection
