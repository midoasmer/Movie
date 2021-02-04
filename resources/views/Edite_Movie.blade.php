@extends('App')

@section('content')

    {!! Form::model($movie,['method'=>'PATCH','action'=>['App\Http\Controllers\MovieController@update',$movie->id]]) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Movie Name','Movie Name') !!}
        {!! Form::text('Name',null,['class'=>'form-control']) !!}

        {!! Form::label('Director Name','Director Name') !!}
        {!! Form::text('Director_Id',null,['class'=>'form-control']) !!}

        {!! Form::label('Actor Name','Actor Name') !!}
        {!! Form::text('Actor_Id',null,['class'=>'form-control']) !!}

        {!! Form::label('Description','Description') !!}
        {!! Form::text('Description',null,['class'=>'form-control']) !!}

        {!! Form::label('Year','Year') !!}
        {!! Form::text('Year',null,['class'=>'form-control']) !!}

    </div>

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



