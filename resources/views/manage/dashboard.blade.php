@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Admin Dashboard')
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 Dashboard</p>
@endsection
@section('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<section>
		<div class="uk-grid-small uk-width-1-1" uk-grid style="padding-top: 1em">
			<div class="uk-width-2-3@m">
				<div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
					<div>
						@widget('admin.dashboard.users')
					</div>
					<div>
						@widget('admin.dashboard.products')
					</div>
					<div>
						@widget('admin.dashboard.posts')
					</div>
					<div>
						@widget('admin.dashboard.orders')
					</div>
				</div>
			</div>
			<div class="uk-width-1-3@m">
				<div class="widget uk-box-shadow-hover-small" style="border-radius: 15px; background-color: #FFF4DE; border-color: #FFF4DE; min-height: 14em">
					<div class="" uk-grid>
						<div class="uk-width-3-4" style="padding:2em 5em">
							<h4 style="color: #FFA800">{{__('main.welcome back')}} !!</h4>
							<p>{{getAuthUser()->name}}</p>
							<br>
							<a class="" href="{{Route('setting.index')}}" style="color: #FFA800">
								{{__('main.site settings')}} <span uk-icon="icon:  chevron-double-right"></span>
							</a>
						</div>
						<div class="uk-width-1-4">
							<img src="{{asset_image('/assets/welcome-boss.svg')}}" style="width: 170px; position: absolute; top: 4.5em; right: 5em">
						</div>
					</div>
				</div>
			</div>
			<div class="uk-width-2-3@m">
				<div id="vue-app">
					@php
					$postId = 20;
					@endphp
					<example v-bind:post_id="{{$postId}}"></example>
				</div>
{{--				@widget('admin.dashboard.changes_log')--}}
			</div>
			<div class="uk-width-1-3@m">
				@widget('admin.dashboard.recent_users')
			</div>
		</div>
	<script src="{{asset('js/app.js')}}"></script>
</section>
@endsection
