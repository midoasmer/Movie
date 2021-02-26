@extends('App')

@section('content')
    @if(Session::has('select'))
        <p class="bg-danger">{{session('select')}}</p>
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
                <select name="Movie_Id" class="form-control">
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
    <br>
    {{--    -------------------------------------------------------------------------------------------------------------------------------------}}
    @if($movier && $actors === 'Non')
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Actor 1 Name</th>
                <th>ID</th>
                <th>Actor 2 Name</th>
                <th>ID</th>
                <th>Actor 3 Name</th>
                <th>Movie</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$movier->actor->id}}</td>
                <td>{{$movier->actor->Name}}</td>
                <td>{{$movier->actor->id}}</td>
                <td>{{$movier->actor->Name}}</td>
                <td>{{$movier->actor->id}}</td>
                <td>{{$movier->actor->Name}}</td>
                <td>{{$movier->Name}}</td>
            </tr>
            </tbody>
        </table>
    @endif
    @if($actors && $movier==='Non')
        <h1>{{$categore->Name}}</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Actor Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach($actors as $actor)
                <tr>
                    <td>{{$actor}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
{{--        {!! $actorss->appends(Request::all())->links() !!}--}}
{{--        {{ $actors->links() }}--}}
    @endif
@endsection




