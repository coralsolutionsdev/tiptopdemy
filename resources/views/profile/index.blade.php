@extends('layouts.main')
@section('title', auth::user()->name)
@section('content')
<section id="profile">
    <div class="container">
        <div class="row ">
            <div class="col">
                <div class="header d-flex justify-content-center align-items-center">
                    <div class="header-image d-flex align-items-center">
                        <img src="{{asset('/uploads/profile/covers/'.auth::user()->cover)}}" class="img-fluid" alt="">
                    </div>
                    <div class="header-body text-center">
                        <div class="avatar"><img src="{{asset('/uploads/profile/avatars/'. auth::user()->avatar)}}" height="120" class="rounded-circle"></div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="section-sm text-white font-weight-bold"><h3>{{ auth::user()->name}}</h3></div>
                        <div class="sectiom-sm">
                            
                            
                            <a href="" class="btn btn-light">edit</a>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!---->
        <div class="row section-md">
            <div class="col ">
                <div class="container section-md">
                @Include('layouts.partials._messages')
                </div>
                <div class="card border-light rounded-0 text-center section-md">

                    <p>Welcome <strong>{{auth::user()->name}}</strong>, you are loginig as {{auth::user()->role}} </p>
                
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
