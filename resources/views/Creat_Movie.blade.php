@extends('App')

@section('content')
<form method="post" action="/Movie">
    @csrf
    <input type="text" name="Name" placeholder="Movie Name"> <br>
    <input type="text" name="Director_Name" placeholder="Director Name"> <br>
    <input type="text" name="Actor_Name" placeholder="Actor Name"> <br>
    <input type="text" name="Description" placeholder="Description "> <br>
    <input type="text" name="Year" placeholder="Year"> <br>

    <input type="submit" name="Save">

</form>
@endsection


