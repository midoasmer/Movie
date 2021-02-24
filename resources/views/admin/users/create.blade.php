@extends('App')

@section('content')

    <h1>Creat User</h1>
    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\AdminUsersController@store','files'=>true]) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Name','Name:') !!}
        {!! Form::text('name',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email','Email:') !!}
        {!! Form::email('email',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status','Status:') !!}
        {!! Form::select('is_active',array(1 => 'Active',0 => 'Not Active'),0,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('role','Role:') !!}
        <select name="role_id" class="form-control">
            <option value="">Choose Option</option>
            @foreach ($roles as $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
        </select>
        {{--        {!! Form::select('role_id',[''=>'Choose Option']+$roles,null,['class'=>'form-control']) !!}--}}
    </div>

    <div class="form-group">
        {!! Form::label('photo','Fail:') !!}
        {!! Form::file('photo',['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password','Password:') !!}
        {!! Form::password('password',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Save ',['class'=>'btn btn-primary']) !!}
    </div>


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
