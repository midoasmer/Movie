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
                <th>From</th>
                <th>To</th>
            </tr>
            <tr>
                <th>
                    <select name="Actor_Id" class="form-control">
                        <option value="{{$movies[0]->actor->id}}">{{$movies[0]->actor->Name}}</option>
                        @foreach ($actors as $actor1)
                            <option value="{{$actor1->id}}">{{$actor1->Name}}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select name="Director_Id" class="form-control">
                        <option value="{{$movies[0]->director->id}}">{{$movies[0]->director->Name}}</option>
                        @foreach ($directors as $director1)
                            <option value="{{$director1->id}}">{{$director1->Name}}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select id="StartYear" name="StartYear" class="form-control">
                        <option value="{{ $startyear }}">{{ $startyear }}</option>
                        {{ $last= date('Y')-80 }}
                        {{ $now = date('Y') }}
                        @for ($i = $now; $i >= $last; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </th>
                <th>
                    <select id="EndYear" name="EndYear" class="form-control">
                        <option value="{{$endyear}}">{{$endyear}}</option>
                        {{ $last= date('Y')-80 }}
                        {{ $now = date('Y') }}
                        @for ($i = $last; $i <= $now; $i++)
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
                    <th>Movie Name</th>
                    <th>Actor Name</th>
                    {{--                <th>Actor Name</th>--}}
                    <th>Actor Name</th>
                    <th>Director Name</th>
                    <th>Description</th>
                    <th>Year</th>
                    <th>Rate</th>
                    @if(Auth::check())
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
                        <td>{{$movie->Name}}</td>
                        {{--                    <td>{{$actor->Name}}</td>--}}
                        <td>{{$movie->actor->Name}}</td>
                        <td>{{$movie->actor->Name}}</td>
                        <td>{{$movie->director->Name}}</td>
                        <td>{{$movie->Description}}</td>
                        <td>{{$movie->Year}}</td>
                        <td>{{$movie->Rating}}</td>
                          @if(Auth::check())
                            {{-- <td><select id="Rating" name="Rating" class="form-control">
                                     <option value="Rate">{{$movie->Rating}}</option>
                                     @for ($i = 1; $i <= 10; $i++)
                                         <option value="Add_Rate">{{ $i }}</option>
                                     @endfor
                                 </select></td>
                         @else
                             <td>{{$movie->Rating}}</td>
                         @endif
                         @if(Auth::check())
                             <td>
                                 <form method="GET" action="/Movie/{{$movie->id}}/edit">
                                     <input type="submit" value="Rate">
                                 </form>
                             </td> --}}
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
                </tbody>
            </table>
{{--            {{ $movies->links() }}--}}
        {!! $movies->appends(Request::all())->links() !!}
        {{--        {!! $movies->render() !!}.--}}
    </ul>

@endsection
