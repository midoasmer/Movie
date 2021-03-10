{{--@extends('layouts.app')--}}
@extends('App')

@section('content')
    @if(Session::has('no_permetion'))
        <p class="bg-danger">{{session('no_permetion')}}</p>
    @endif
    <div class="row">
        <div class="col-sm-3">
            <img height="150" src="{{Auth::user()->photo ? Auth::user()->photo->file :'http://placehold.it/400x400'}}"
                 alt=""
                 class="img-responsive img-rounded">
        </div>
        <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">{{ Auth::user()->role->name }} : Page</div>

                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <h1>Welcome : {{ Auth::user()->name }}</h1>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
@endsection
