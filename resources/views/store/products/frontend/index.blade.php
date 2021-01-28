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
@endsection
@section('content')
	<section>
		<div class="store uk-container uk-margin-medium-bottom" style="background-color: transparent">
			{{--header--}}
			@include('partial.frontend._page-header')
			{{--body--}}
			<product-index category-id="{{ !empty($category) ? strval($category->id) : '0' }}"></product-index>

		</div>
	</section>
	@include('partial.frontend._full_loading')
@endsection