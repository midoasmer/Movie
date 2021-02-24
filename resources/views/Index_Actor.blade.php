@extends('App')

@section('content')
    @if(Session::has('created_actor'))
        <p class = "bg-danger">{{session('created_actor')}}</p>
    @endif

    @if(Session::has('updated_actor'))
        <p class = "bg-danger">{{session('updated_actor')}}</p>
    @endif

    @if(Session::has('deleted_actor'))
        <p class = "bg-danger">{{session('deleted_actor')}}</p>
    @endif
        @csrf
        <h1>Actors</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>


                @foreach($actors as $actor)
                    <tr>
                        <td>{{$actor->id}}</td>
                        <td><img height="50" src="{{$actor->photo ? $actor->photo->file :'http://placehold.it/50x50'}}"></td>
                        <td>{{$actor->Name}}</td>
                        <td>{{$actor->gender}}</td>
                        <td>{{$actor->birthdate}}</td>
                        <td>{{$actor->created_at->diffForHumans()}}</td>
                        <td>{{$actor->updated_at->diffForHumans()}}</td>
                        <td>
                            <form method="GET" action="/Actor/{{$actor->id}}/edit">
                                <input type="submit" value="Update">
                            </form>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\ActorController@destroy',$actor->id]]) !!}
                            {!! Form::submit('Delete Actor',['class'=>'btn btn-danger']) !!}
                            {!! Form:: close() !!}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    {{ $actors->links() }}
{{--        <ul>--}}
{{--            @foreach( $actors as $actor)--}}
{{--                <li><a href="{{route('Actor.show',$actor->id)}}"> {{$actor->Name}}</a></li><br>--}}
{{--                <form method="GET" action="/Actor/{{$actor->id}}/edit">--}}
{{--                <input type="submit" value="Update">--}}
{{--                </form>--}}
{{--                {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\ActorController@destroy',$actor->id]]) !!}--}}
{{--                {!! Form::submit('Delete Actor',['class'=>'btn btn-danger']) !!}--}}
{{--                {!! Form:: close() !!}--}}
{{--            @endforeach--}}
{{--        </ul>--}}
@endsection


