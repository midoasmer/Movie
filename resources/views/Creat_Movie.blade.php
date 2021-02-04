@extends('App')

@section('content')

   {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\MovieController@store']) !!}
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

        {!! Form::submit('Save Movie',['class'=>'btn btn-primary']) !!}

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


   {{--<form method="post" action="/Movie">--}}
    {{--   @csrf--}}
    {{--    <input type="text" name="Name" placeholder="Movie Name"> <br>--}}
    {{--    <input type="text" name="Director_Name" placeholder="Director Name"> <br>--}}
    {{--    <input type="text" name="Actor_Name" placeholder="Actor Name"> <br>--}}
    {{--    <input type="text" name="Description" placeholder="Description "> <br>--}}
    {{--    <input type="text" name="Year" placeholder="Year"> <br>--}}
    {{--    <input type="submit" name="Save">--}}

    {{--</form>--}}
@endsection


