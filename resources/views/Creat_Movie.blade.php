@extends('App')
@if(Auth::user()->isAdmin())
@section('content')
    <h1>Creat Movie</h1>
    {!! Form::open(['method'=>'POST','action'=>'App\Http\Controllers\MovieController@store','files'=>true]) !!}
    @csrf
    <div class="form-group">
        {!! Form::label('Movie Name','Movie Name') !!}
        {!! Form::text('Name',null,['class'=>'form-control']) !!}
        <div id="add" class="form-group">
            {!! Form::label('Actor Name','Actor Name') !!}
            <select id="mySelect0" name="Actor0" class="form-control">
                @foreach ($actors as $actor)
                    <option value="{{$actor->id}}">{{$actor->Name}}</option>
{{--                    <script>--}}
{{--                        var n = 1;--}}
{{--                        function anotherActor() {--}}
{{--                            "use strict";--}}
{{--                            if (n < 3) {--}}
{{--                                var input = document.createElement("SELECT");--}}
{{--                                input.setAttribute("id", "mySelect" + n);--}}
{{--                                input.setAttribute('name', 'Actor' + n);--}}
{{--                                input.setAttribute('class', "form-control");--}}
{{--                                var parent = document.getElementById("add");--}}
{{--                                parent.appendChild(input);--}}
{{--                                    @foreach ($actors as $actor)--}}
{{--                                var z = document.createElement("option");--}}
{{--                                z.setAttribute("value", "{{$actor->id}}");--}}
{{--                                var t = document.createTextNode("{{$actor->Name}}");--}}
{{--                                z.appendChild(t);--}}
{{--                                document.getElementById("mySelect" + n).appendChild(z);--}}
{{--                                @endforeach--}}
{{--                                    n++;--}}
{{--                            } else {--}}
{{--                                alert('Sorry You Can only Add 3 Actors To The Movie');--}}
{{--                            }--}}
{{--                        }--}}
{{--                    </script>--}}
                @endforeach
            </select>
        </div>
        <button form="form" onclick="anotherActor({{$actors}})" class="btn btn-primary">Add Another Actor</button>
        <br>
        {!! Form::label('Director Name','Director Name') !!}
        <select name="Director_Id" class="form-control">
            @foreach ($directors as $director)
                <option value="{{$director->id}}">{{$director->Name}}</option>
            @endforeach
        </select>
        <br>
        {!! Form::label('Category','Category') !!}
        <select name="Category_id" class="form-control">
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->Name}}</option>
            @endforeach
        </select>
        <br>
        {!! Form::label('Description','Description') !!}
        {!! Form::text('Description',null,['class'=>'form-control']) !!}

        {!! Form::label('Year','Year') !!}
        <select id="Year" name="Year" class="form-control ">
            {{ $last= date('Y')-120 }}
            {{ $now = date('Y') }}
            @for ($i = $now; $i >= $last; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <br>
    {!! Form::file('image',['class'=>'form-control']) !!}
    <br>
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
@else
    <script>
        window.location = "/";
        {{Session::flash('no_permetion','You Dont Have Apermation')}}
    </script>
    {{--this script to add anew actor --}}
    <script>
        var n = 1;

        function addFeilde() {
            "use strict";
            if (n < 3) {
                var input = document.createElement("SELECT");
                input.setAttribute("id", "mySelect" + n);
                input.setAttribute('name', 'Actor' + n);
                var parent = document.getElementById("add");
                parent.appendChild(input);
                    @foreach ($actors as $actor)
                var z = document.createElement("option");
                z.setAttribute("value", "{{$actor->id}}");
                var t = document.createTextNode("{{$actor->Name}}");
                z.appendChild(t);
                document.getElementById("mySelect" + n).appendChild(z);
                @endforeach
                    n++;
            } else {
                alert('Sorry You Can only Add 3 Actors To The Movie');
            }
        }
    </script>
@endif

