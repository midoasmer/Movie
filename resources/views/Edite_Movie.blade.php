@extends('App')

@section('content')
    @if(Session::has('updated_movie'))
        <p class="bg-danger">{{session('updated_movie')}}</p>
    @endif
    {!! Form::model($movie,['method'=>'PATCH','action'=>['App\Http\Controllers\MovieController@update',$movie->id],'files'=>true]) !!}
    @csrf
    <div class="form-group">
        @if(Auth::user()->isAdmin())
            {!! Form::label('Movie Name','Movie Name') !!}
            {!! Form::text('Name',null,['class'=>'form-control']) !!}
            <div id="add" class="form-group">
                {!! Form::label('Actor Name','Actor Name') !!}
                @php
                    $count=0;
                @endphp
                @foreach ($movie->actors as $act)
                    <select id="mySelect0" name="Actor{{$count}}" class="form-control">
                        <option value="{{$act->id}}">{{$act->Name}}</option>
                        <option value="0">Delete Actor</option>
                        @foreach ($actors as $actor)
                            <option value="{{$actor->id}}">{{$actor->Name}}</option>
                        @endforeach
                    </select>
                    @php
                        $count++;
                    @endphp
                @endforeach
            </div>
            {{--        the function in the button in {public/js/app2}--}}
            <button form="form" onclick="anotherActor1('0','Select Actor',{{$actors}},{{$count}})"
                    class="btn btn-primary">
                Add Another Actor
            </button>
            <br>
            {!! Form::label('Director Name','Director Name') !!}
            <select name="Director_Id" class="form-control">
                <option value="{{$movie->director->id}}">{{$movie->director->Name}}</option>
                @foreach ($directors as $director)
                    <option value="{{$director->id}}">{{$director->Name}}</option>
                @endforeach
            </select>
            <br>
            <div id="addCategory" class="form-group">
                {!! Form::label('Category','Category') !!}
                @php
                    $count1=0;
                @endphp
                @foreach ($movie->categories as $cat)
                    <select id="categorySelect0" name="Category{{$count1}}" class="form-control">
                        <option value="{{$cat->id}}">{{$cat->Name}}</option>
                        <option value="0">Delete Category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->Name}}</option>
                    @endforeach
                </select>
                    @php
                        $count1++;
                    @endphp
                @endforeach
            </div>
            {{--        the function in the button in {public/js/app2}--}}
            <button form="form" onclick="anotherCategory1('0','Select Category',{{$categories}},{{$count1}})"
                    class="btn btn-primary">
                Add Another Category
            </button>
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
        {!! Form::label('Review','Review') !!}
        {!! Form::text('Review',value($review),['class'=>'form-control']) !!}
        {!! Form::label('Rate','Your Rate : '.$rate) !!}
        <select id="Rate" name="Rate" class="form-control">
            @if($rate==="Not Rated")
                <option value="No Rate">No Rate</option>
            @else
                <option value={{$rate}}>{{$rate}}</option>
            @endif
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
