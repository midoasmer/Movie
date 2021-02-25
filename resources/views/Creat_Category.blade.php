@extends('App')

@section('content')
    <h1>Creat Category</h1>
    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\CategoryController@store']) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Category Name','Category Name') !!}
        {!! Form::text('Name',null,['class'=>'form-control']) !!}
    <br>
    {!! Form::submit('Save Category',['class'=>'btn btn-primary']) !!}

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
