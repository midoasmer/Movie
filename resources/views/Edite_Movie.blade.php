@extends('App')

@section('content')

    {!! Form::model($movie,['method'=>'PATCH','action'=>['App\Http\Controllers\MovieController@update',$movie->id],'files'=>true]) !!}
    @csrf
    <div class="form-group">
        @if(Auth::user()->isAdmin())
            {!! Form::label('Movie Name','Movie Name') !!}
            {!! Form::text('Name',null,['class'=>'form-control']) !!}

            {!! Form::label('Actor Name','Actor Name') !!}
            <select name="Actor_Id" class="form-control">
                @foreach ($actors as $actor)
                    <option value="{{$actor->id}}">{{$actor->Name}}</option>
                @endforeach
            </select>
            <br>
            {!! Form::label('Director Name','Director Name') !!}
            <select name="Director_Id" class="form-control">
                @foreach ($directors as $director)
                    <option value="{{$director->id}}">{{$director->Name}}</option>
                @endforeach
            </select>
            <br>

            {!! Form::label('Description','Description') !!}
            {!! Form::text('Description',null,['class'=>'form-control']) !!}

            {!! Form::label('Year','Year') !!}
            <select id="Year" name="Year" class="form-control ">
                <option value="{{$movie->Year}}">{{ $movie->Year }}</option>
                {{ $last= date('Y')-120 }}
                {{ $now = date('Y') }}
                @for ($i = $now; $i >= $last; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        @endif
        {!! Form::label('Rate','Rate : '.$movie->Rate->rate) !!}
        <select id="Rate" name="Rate" class="form-control">
            @for ($i = 1; $i <= 10; $i++)
                <option value={{$i}}>{{ $i }}</option>
            @endfor
        </select>
    </div>
    @if(Auth::user()->isAdmin())
        <div class="image-container">
            <img height="200" src="{{$movie->photo ? $movie->photo->file :'http://placehold.it/50x50'}}">
        </div>
        <br>
        {!! Form::file('image',['class'=>'form-control']) !!}
    @endif
    <br>
    {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
    {!! Form:: close() !!}

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



