@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
    <style>
        html, body{
            height: 100%;
        }
    </style>
    <link rel="stylesheet" href="{{asset('themes/general/modules/css/at.css?v=202104071230')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')
    <div id="vue-app">
        <smart-form-create current-unit-num="{{$unitNumber}}" current-lesson-num="{{$lessonNumber}}" lesson-slug="{{$lesson->slug}}"></smart-form-create>
    </div>
    @include('partial.scripts._tinyemc')
    <script src="{{asset('js/app.js?v=202104071230')}}"></script>

@endsection
