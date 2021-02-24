@extends('App')

@section('content')

    <form method="GET" action="/Movie/{{$movie->id}}/edit">
        <ul>

            <h1>Movie Name:  {{$movie->Name}}</h1><br>
            <h1>Actor Name: {{$actor->Name}}</h1><br>
            <h1>Director Name: {{$director->Name}}</h1><br>
            <h1>Descreption: {{$movie->Description}}</h1><br>
            <h1>Year: {{$movie->Year}}</h1><br>
            <div class="image-container">

                <img src="/images/{{$movie->Image}}">

            </div>

        </ul>
    </form>

{{--    <form method="post" action="/Movie/{{$movie->id}}">--}}
{{--        <input type="hidden" name="_method" value="DELETE">--}}
{{--        @csrf--}}
{{--        <input type="submit" value="Delete">--}}
{{--    </form>--}}


    <form method="GET" action="/Movie">
        <input type="submit" value="Movies List">
    </form>

@endsection
