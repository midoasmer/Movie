@extends('App')

@section('content')

    <form method="GET" action="/Movie/{{$movie->id}}/edit">
{{--        <input type="hidden" name="_method" value="DELETE">--}}
        @csrf
        <ul>

            <h1>Movie Name:  {{$movie->Name}}</h1><br>
            <h1>Actor Name: {{$movie->Actor_Id}}</h1><br>
            <h1>Director Name: {{$movie->Director_Id}}</h1><br>
            <h1>Descreption: {{$movie->Description}}</h1><br>
            <h1>Year: {{$movie->Year}}</h1><br>

        </ul>
        <input type="submit" value="Update">
    </form>


    <form method="post" action="/Movie/{{$movie->id}}">
        <input type="hidden" name="_method" value="DELETE">
        @csrf
        <input type="submit" value="Delete">
    </form>


    <form method="GET" action="/Movie">
        <input type="submit" value="Movies List">
    </form>

@endsection
