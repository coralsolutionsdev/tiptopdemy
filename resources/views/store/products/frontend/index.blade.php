@extends('themes.'.getFrontendThemeName().'.v2.layout')
@section('title', $page_title)
@section('head')
	<style>
		.color-option{
			height: 22px;
			width: 22px !important;
			border-radius: 50%;
			border: 1px solid #566573;
			display: inline-block;
		}
	</style>
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
	<section>
		<div class="store uk-container uk-margin-medium-bottom" style="background-color: transparent">
			{{--header--}}
			@include('partial.frontend._page-header')
			{{--body--}}
			<product-index></product-index>

		</div>
{{--		@include('partial.scripts._cart')--}}
	</section>
@endsection