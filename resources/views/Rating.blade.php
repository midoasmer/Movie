@extends('App')

@section('content')
    <h1>Edit Rating And Review</h1>
    {{--    {!! Form::model($movie,['method'=>'PATCH','action'=>['App\Http\Controllers\MovieController@update',$movie->id],'files'=>true]) !!}--}}
    @csrf
    <form method="GET" action="/Rating">
    <div class="form-group">
        {!! Form::label('Movie Name','Movie Name') !!}
        {!! Form::label($movie->Name,null,['class'=>'form-control']) !!}
        {!! Form::label('Review','Review') !!}
        {!! Form::text('Review',value($review),['class'=>'form-control']) !!}
        <input name="movie_id" type="hidden" value="{{$movie->id}}">
        {!! Form::label('Rate','Your Rate : '.$rate) !!}
        <select id="Rate" name="Rate" class="form-control">
            @if($rate==="Not Rated")
                <option value="No Rate">No Rate</option>
            @else
                <option value={{$rate}}>{{$rate}}</option>
            @endif
            @for ($i = 1; $i <= 10; $i++)
                <option value={{$i}}>{{ $i }}</option>
            @endfor
        </select>
    </div>

        <input type="submit" value="Update" class='btn btn-primary'>
    </form>

    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection




