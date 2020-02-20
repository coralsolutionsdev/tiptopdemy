@extends('layouts.main')
@section('title', $user->name)
@section('content')
<section id="profile">
    <div class="container">
        <div class="row ">
            <div class="col">
                <div class="header d-flex justify-content-center align-items-center">
                    <div class="header-image d-flex align-items-center">
                        <img src="{{asset('/uploads/profile/covers/'.$user->cover)}}" class="img-fluid" alt="">
                    </div>
                    <div class="header-body text-center">
                        <div class="avatar"><img src="{{asset('/uploads/profile/avatars/'.$user->avatar)}}" height="120" class="rounded-circle"></div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="section-sm text-white font-weight-bold"><h3>{{$user->name}}</h3></div>
                        <div class="section-sm">
                            @guest
                                <a href="" class="btn btn-primary">Message</a>
                            @else
                                @if(auth::user()->id != $user->id)
                                <a href="" class="btn btn-primary">Message</a>
                                @endif
                                @if(auth::user()->IsAdmin() or auth::user()->id == $user->id)
                                <a href="" class="btn btn-light">edit</a>
                                @endif
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!---->
        <div class="row section-md">
            <div class="col ">
                <div class="card border-light rounded-0 text-center section-md">
                    <!-- Posts header-->
                    <p>No reviews available</p>
                    <!-- Posts header end-->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
