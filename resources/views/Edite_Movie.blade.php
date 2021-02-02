@extends('App')

@section('content')
    <form method="post" action="/Movie/{{$movie->id}}">
        <input type="hidden" name="_method" value="PUT">
        @csrf
        <input type="text" name="Name" placeholder="Movie Name" value="{{$movie->Name}}"> <br>
        <input type="text" name="Director_Name" placeholder="Director Name" value="{{$movie->Director_Id}}"> <br>
        <input type="text" name="Actor_Name" placeholder="Actor Name"  value="{{$movie->Actor_Id}}"> <br>
        <input type="text" name="Description" placeholder="Description" value="{{$movie->Description}}"> <br>
        <input type="text" name="Year" placeholder="Year" value="{{$movie->Year}}"> <br>

        <input type="submit" name="Save">

    </form>
@endsection



