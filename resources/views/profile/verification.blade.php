@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', auth::user()->name)
@section('content')
<section id="profile">
    <div class="container">
        <!---->
        <div class="row section-md">
            <div class="col ">
                <div class="container section-md">
                @Include('layouts.partials._messages')
                </div>
                <div class="card border-light rounded-0 text-center section-md">

                    <p>Welcome <strong>{{auth::user()->name}}</strong>, you are loginig as {{auth::user()->role}} </p>
                    <strong>PLEASE!</strong><p>activate your account</p>
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

