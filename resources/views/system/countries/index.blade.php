@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
	<a href="{{Route('posts.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('content')

	<section>
		{{--Page header--}}
		@include('manage.partials._page-header')
		{{--List of items--}}
		<div>
			<div class="card border-light table-card">
				<div class="card-body">
					<table class="table table-striped">
						<thead>
						<tr>
							<td class="text-capitalize" width="20">{{__('flag')}}</td>
							<td class="text-capitalize"> {{__('name')}}</td>
							<td class="text-capitalize" width="20">{{__('code')}}</td>
							<td class="text-capitalize">{{__('native name')}}</td>
							<td class="text-capitalize">{{__('status')}}</td>
						</tr>
						</thead>
						<tbody>
						@foreach ($countries as $code => $country)
							<tr>
								<td class="flag text-left"><img src="https://lipis.github.io/flag-icon-css/flags/4x3/{{$code}}.svg" style="width: 20px;" alt=""></td>
								<td>{{Country($code)->getName()}}</td>
								<td>{{$code}}</td>
								<td>{{Country($code)->getNativeName()}}</td>
								<td>
									{!! getStatusIcon(in_array($code, \App\Site::COUNTRIES_ARRAY) ? 1 : 0) !!}
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div>
		</div>
	</section>

@endsection
@section('script')
@endsection
