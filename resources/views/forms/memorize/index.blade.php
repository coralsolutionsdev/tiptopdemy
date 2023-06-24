@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
<a href="{{Route('form.memorize.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		html,body{
			height: 100%;
		}
	</style>
@endsection
@section('content')

<section>
	{{--Page header--}}
	@include('manage.partials._page-header')
	{{--List of items--}}
	<div id="vue-app">
		<memorize-index></memorize-index>
	</div>
	<div>
{{--		{{$templates->links()}}--}}
	</div>
</section>
<script src="{{asset('/js/app.js?v=202306240610')}}"></script>

@endsection
@section('script')
@endsection
