@extends('App')
@section('content')
@if(Session::has('created_category'))
    <p class = "bg-danger">{{session('created_category')}}</p>
@endif

@if(Session::has('updated_category'))
    <p class = "bg-danger">{{session('updated_category')}}</p>
@endif

@if(Session::has('deleted_category'))
    <p class = "bg-danger">{{session('deleted_category')}}</p>
@endif
@if(Session::has('cant_delete'))
    <p class = "bg-danger">{{session('cant_delete')}}</p>
@endif
@csrf
<h1>Categories</h1>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>

    @foreach($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->Name}}</td>
            <td>{{$category->created_at->diffForHumans()}}</td>
            <td>{{$category->updated_at->diffForHumans()}}</td>
            <td>
                <form method="GET" action="/Category/{{$category->id}}/edit">
                    <input type="submit" value="Update">
                </form>
            </td>
            <td>
                {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\CategoryController@destroy',$category->id]]) !!}
                {!! Form::submit('Delete Category',['class'=>'btn btn-danger']) !!}
                {!! Form:: close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $categories->links() }}
@endsection
