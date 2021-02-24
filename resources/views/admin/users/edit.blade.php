@extends('App')

@section('content')

    <h1>Edit User</h1>

    <div class="row">
        <div class="col-sm-3">
            <img height="200" src="{{$user->photo ? $user->photo->file :'http://placehold.it/200x200'}}" alt=""
                 class="img-responsive img-rounded">

        </div>

        <div class="col-sm-9">
            {!! Form::model($user,['method'=>'PATCH','action'=>['App\Http\Controllers\AdminUsersController@update',$user->id],'files'=>true]) !!}
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
                {!! Form::select('is_active',array(1 => 'Active',0 => 'Not Active'),Null,['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('role','Role:') !!}
                <select name="role_id" class="form-control">
                    <option value="{{$user->role_id}}">{{$user->role->name}}</option>
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
                {!! Form::submit('Update ',['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form:: close() !!}
        </div>
    </div>
    <div class="row">
        @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


@endsection

