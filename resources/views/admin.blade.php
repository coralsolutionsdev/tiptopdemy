@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Admin Dashboard')
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 Dashboard</p>
@endsection
@section('content')
<div class="container-fluid">
    
<p>Welcome <strong>{{auth::user()->name}}</strong>, you are loginig as {{auth::user()->role}} </p>
<p>Posts {{$postcount}}</p>
<p>Users {{$usercount}}</p>
                   
                   @if(auth::user()->role == 'admin')
                   @Include('layouts.admin')
                   @else
                   @Include('layouts.user')
                   @endif
                    
               
</div>
@endsection
