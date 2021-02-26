@extends('App')

@section('content')
    @if(Session::has('select'))
        <p class = "bg-danger">{{session('select')}}</p>
    @endif
    <h1>Actors Search</h1>
    {!! Form::open(array('method'=>'GET','action'=>'App\Http\Controllers\SearchController@ShowActor')) !!}
    <table style="width:100%">
        <tr>
            <th>Movie</th>
            <th>Category</th>
        </tr>
        <tr>
            <th>
                <select name="Movie_Id" class="form-control" >
                    <option value="Non">Select Movie</option>
                    @foreach ($movies as $movie)
                        <option value="{{$movie->id}}">{{$movie->Name}}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <select name="Category_Id" class="form-control">
                    <option value="Non">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->Name}}</option>
                    @endforeach
                </select>
            </th>
        </tr>
    </table>
    <br>
    {!! Form::submit('Search Actors',['class'=>'btn btn-primary']) !!}
    {!! Form:: close() !!}
@endsection



