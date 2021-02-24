@extends('App')

@section('content')
    {!! Form::open(array('method'=>'GET','action'=>'App\Http\Controllers\SearchController@show')) !!}
    <table style="width:100%">
        <tr>
            <th>Actor Name</th>
            <th>Director Name</th>
            <th>From</th>
            <th>To</th>
        </tr>
        <tr>
            <th>
                <select name="Actor_Id" class="form-control" >
                    @foreach ($actors as $actor1)
                        <option value="{{$actor1->id}}">{{$actor1->Name}}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <select name="Director_Id" class="form-control">
                    @foreach ($directors as $director1)
                        <option value="{{$director1->id}}">{{$director1->Name}}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <select id="StartYear" name="StartYear" class="form-control ">
                    {{ $last= date('Y')-80 }}
                    {{ $now = date('Y') }}
                    @for ($i = $now; $i >= $last; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </th>
            <th>
                <select id="EndYear" name="EndYear" class="form-control ">
                    {{ $last= date('Y')-80 }}
                    {{ $now = date('Y') }}
                    @for ($i = $last; $i <= $now; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </th>
        </tr>
    </table>
    <br>
    {!! Form::submit('Search Movies',['class'=>'btn btn-primary']) !!}
    {!! Form:: close() !!}
@endsection


