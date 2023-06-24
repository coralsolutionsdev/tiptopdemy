@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
@endsection
@section('head')
    <style>
        html,body{
            /*height: 100vh;*/
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div id="vue-app">
        <file-manager v-bind:insertmode="false"></file-manager>
    </div>
    <script src="{{asset('js/app.js?v=202306240724')}}"></script>
@endsection
