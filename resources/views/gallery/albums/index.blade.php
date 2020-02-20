@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._albums'))
@section('page-header-button')
	@Include('layouts.partials.modals._add_new_album')
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
						<th scope="col">{{trans('main._title')}}</th>
						<th scope="col">{{trans('main._description')}}</th>
						<th scope="col">{{trans('main._user')}}</th>
						<th scope="col" class="text-center">{{trans('main._status')}}</th>
						<th scope="col" scope="col" class="text-center" width="200">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($albums as $album)
						<tr>
							<td class="align-middle">{{$album->title}}</td>
							<td class="align-middle">{{$album->description}}</td>
							<td class="align-middle">{{$album->user->name}}</td>
							<td class="text-center align-middle">{!! getStatusIcon($album->status) !!}</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
									<ul>
										<li class="">
											<a target="_blank" href="" class="btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>
										</li>
										<li class="">
											<a href="{{route('albums.edit', $album->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
										</li>
										<li class="">
											<span id="{{$album->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
											<form id="delete-form" method="post" action="{{route('albums.destroy', $album->id)}}">
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
	<div>
		{{$albums->links()}}
	</div>
</section>
@endsection
