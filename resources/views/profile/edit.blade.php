@extends('layouts.main')
@section('title', $user->name)
@section('content')
<section id="profile">
    <div class="container">
        <div class="row ">
            <div class="col padding-0">
                <div class="header d-flex justify-content-center align-items-center">
                    <div class="header-image d-flex align-items-center">
                        <img src="{{asset('/uploads/profile/covers/'.$user->cover)}}" class="img-fluid" alt="">
                    </div>
                    <div class="header-body text-center">
                        <div class="avatar"><img src="{{asset('/uploads/avatars/'.$user->avatar)}}" height="120" class="rounded-circle"></div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="section-sm text-white font-weight-bold"><h3>{{$user->name}}</h3></div>
                        <div class="">
                            <a href="{{route('contact')}}" class="btn btn-primary">Message</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---->
        <div class="row section-md">
            
                <div class="col-lg card border-light rounded-0">
                <div class="section-sm"></div>
                    <ul class="nav mb-3" id="pills-tab" role="tablist">
                      
                      <li class="nav-item">
                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-expanded="true">Profile</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-expanded="true">Password</a>
                      </li>
                      
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      
                      <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">Home...</div>
                      <div class="tab-pane fade " id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">Password ...</div>
                      
                    </div>                   

                </div>
            
        </div>
    </div>
</section>
@endsection
