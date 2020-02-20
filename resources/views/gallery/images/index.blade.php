@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._pictures'))
@section('page-header-button')
	@Include('layouts.partials.modals._add_new_image')
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
						<th scope="col" colspan="" class="text-center">{{trans('main._image')}}</th>
						<th scope="col">{{trans('main._title')}}</th>
						<th scope="col">{{trans('main._description')}}</th>
						<th scope="col" class="text-center">{{trans('main._album')}}</th>
						<th scope="col" class="text-center">{{trans('main._user')}}</th>
						<th scope="col" class="text-center">{{trans('main._status')}}</th>
						<th scope="col" scope="col" class="text-center" width="200">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($images as $image)
						<tr>
							<td style="width: 120px">
								@if ( !empty ( $image->image ) )
									<img src="{{asset_image($image->image)}}" style="width: 100%">
								@else
									<img src="{{asset_image('temp/no_image.png')}}" style="width: 100%">
								@endif
							</td>
							<td class="align-middle">{{$image->title}}</td>
							<td class="align-middle">{{$image->description}}</td>
							<td class="align-middle text-center">{{$image->album->title}}</td>
							<td class="align-middle text-center">{{$image->user->name}}</td>
							<td class="text-center align-middle">{!! getStatusIcon($image->status) !!}</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
									<ul>
										<li class="">
											<a target="_blank" href="" class="btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>
										</li>
										<li class="">
											<a href="{{route('images.edit', $image->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
										</li>
										<li class="">
											<span id="{{$image->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
											<form id="delete-form" method="post" action="{{route('images.destroy', $image->id)}}">
												{{csrf_field()}}
												{{method_field('DELETE')}}
											</form>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="pagination d-flex justify-content-center">
		{{$images->links()}}
	</div>
</section>
{{--Edit image--}}
@endsection
