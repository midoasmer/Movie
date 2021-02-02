@extends('App')

@section('content')
    <form >
        @csrf
        <ul>

            @foreach($movies as $movie)
                <li><a href="{{route('Movie.show',$movie->id)}}"> {{$movie->Name}}</a></li><br>
{{--                <li>{{$movie->Actor_Id}}</li>--}}
{{--                <li>{{$movie->Director_Id}}</li>--}}
{{--                <li>{{$movie->Description}}</li>--}}

            @endforeach

        </ul>


    </form>
@endsection

