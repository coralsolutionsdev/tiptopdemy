@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>Welcome <strong>{{auth::user()->name}}</strong>, you are loginig as {{auth::user()->role}} </p>
                @if(auth::user()->role == 'admin')
                   @Include('layouts.admin')
                   @else
                   @Include('layouts.user')
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
