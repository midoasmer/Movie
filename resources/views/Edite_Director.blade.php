@extends('App')

@section('content')

    {!! Form::model($director,['method'=>'PATCH','action'=>['App\Http\Controllers\DirectorController@update',$director->id],'files'=>true]) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Director Name','Director Name') !!}
        {!! Form::text('Name',null,['class'=>'form-control']) !!}

        {!! Form::label('Date of Birth','Date of Birth') !!}
        {!! Form::text('birthdate',null,['class'=>'form-control']) !!}
        {!! Form::label('Gender','Gender') !!}
        <select name="gender" class="form-control">
            <option value="Male">Male</option>
            <option value="Femal">Femal</option>
        </select>
{{--        {!! Form::label('Gender','Gender') !!}--}}
{{--        {!! Form::text('gender',null,['class'=>'form-control']) !!}--}}
    </div>

    <div class="image-container">
        <img height="200" src="{{$director->photo ? $director->photo->file :'http://placehold.it/50x50'}}">
    </div>
    <br>
    <br>
    {!! Form::file('image',['class'=>'form-control']) !!}
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



    {{--    <form method="post" action="/Movie/{{$movie->id}}">--}}
    {{--        <input type="hidden" name="_method" value="PUT">--}}
    {{--        @csrf--}}
    {{--        <input type="text" name="Name" placeholder="Movie Name" value="{{$movie->Name}}"> <br>--}}
    {{--        <input type="text" name="Director_Name" placeholder="Director Name" value="{{$movie->Director_Id}}"> <br>--}}
    {{--        <input type="text" name="Actor_Name" placeholder="Actor Name"  value="{{$movie->Actor_Id}}"> <br>--}}
    {{--        <input type="text" name="Description" placeholder="Description" value="{{$movie->Description}}"> <br>--}}
    {{--        <input type="text" name="Year" placeholder="Year" value="{{$movie->Year}}"> <br>--}}

    {{--        <input type="submit" name="Save">--}}

    {{--    </form>--}}
@endsection




