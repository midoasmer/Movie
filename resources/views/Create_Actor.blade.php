@extends('App')

@section('content')

    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\ActorController@store','files'=>true]) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Actor Name','Actor Name') !!}
        {!! Form::text('Name',null,['class'=>'form-control']) !!}

        {!! Form::label('Date of Birth','Date of Birth') !!}
        {!! Form::text('birthdate',null,['class'=>'form-control']) !!}
        <br>
        {!! Form::label('Gender','Gender') !!}
        <select name="gender" class="form-control">
            <option value="Male">Male</option>
            <option value="Femal">Femal</option>
        </select>

{{--        {!! Form::label('Gender','Gender') !!}--}}
{{--        {!! Form::text('gender',null,['class'=>'form-control']) !!}--}}

    </div>
    <br>
    {!! Form::file('image',['class'=>'form-control']) !!}
    {!! Form::submit('Save Actor',['class'=>'btn btn-primary']) !!}

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


