@extends('layouts.main')
@section('title','Gallery')
@section('content')

<section class="page-header">
    <div class="container">
        <h2>{{trans('main._gallery')}}</h2>
        <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._gallery')}} / {{$album->title}}</p></small>
    </div>
</section>
<section class="section">
    <div class="container card border-light">
        <div class="row section-md d-flex justify-content-center">
            <h3>{{$album->title}}</h3>
        </div>
        <div class="row">
            <!-- Album -->
            @foreach($images as $image)
            <div id="album" class="col-md-4 col-lg-3 d-flex align-items-center">
                <a href="{{asset('uploads/gallery/images/'.$image->image)}}" data-lightbox="gallery" data-title="{{$image->description}}">
                    <div class="photo d-flex justify-content-center align-items-center">

                        <div class="photo-image d-flex align-items-center">

                            <img src="{{asset('uploads/gallery/images/'.$image->image)}}" class="img-fluid" alt="">

                        </div>

                        <div class="photo-caption d-flex justify-content-center align-items-center">
                            <div class="caption">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                            </div>

                        </div>

                    </div>
                </a>
            </div>

            @endforeach


        </div>
    </div>
</section>
<div class="text-center">
    <div class="d-flex justify-content-center pagination">
        {!!$images->render()!!}
    </div>
</div>
@endsection<?php
