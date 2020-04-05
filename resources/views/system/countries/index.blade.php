@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
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
							<td class="text-capitalize" width="20">{{__('simple')}}</td>
							<td class="text-capitalize" width="20">{{__('currency')}}</td>
							<td class="text-capitalize">{{__('full name')}}</td>
							<td class="text-capitalize">{{__('status')}}</td>
						</tr>
						</thead>
						<tbody>
						@foreach ($countries as $country)
							<tr>
								<td class="flag text-left"><img src="https://lipis.github.io/flag-icon-css/flags/4x3/{{strtolower($country->iso_3166_2)}}.svg" style="width: 20px;" alt=""></td>
								<td>{{$country->name}}</td>
								<td>{{$country->iso_3166_2}}</td>
								<td>{{$country->currency_code}}</td>
								<td>{{$country->full_name}}</td>
								<td>
									{!! Form::open(['url' => route('system.countries.update', $country->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
									<input type="checkbox" name="status" onchange="this.form.submit()" class="toogle-switch"  value="1"  {{empty($country) || !empty($country->status) ? 'checked' : null}}>
									{!! Form::close() !!}
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
		<div>
			{{$countries->links()}}
		</div>
	</section>

@endsection
@section('script')
@endsection
