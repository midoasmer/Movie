@extends('App')
@section('content')

    {!! Form::model($category,['method'=>'PATCH','action'=>['App\Http\Controllers\CategoryController@update',$category->id],'files'=>true]) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Category Name','Category Name') !!}
        {!! Form::text('Name',null,['class'=>'form-control']) !!}
    </div>
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

