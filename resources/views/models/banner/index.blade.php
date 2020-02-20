@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._banners'))
@section('page-header-button')
	<a href="{{Route('banners.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
						<th scope="col" width="30">{{__('Image')}}</th>
						<th scope="col">{{__('Post')}}</th>
						<th scope="col" class="text-center">{{__('Category')}}</th>
						<th scope="col" class="text-center">{{__('Status')}}</th>
						<th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($banners as $banner)
						<tr>
							<td style="width: 120px">
								@if ( !empty ( $banner->image ) )
{{--									<img src="{{asset_image($banner->image)}}" style="width: 100%">--}}
									<img src="{{asset_image($banner->image)}}" style="width: 100%">
								@else
									<img src="{{asset_image('temp/no_image.png')}}" style="width: 100%">
								@endif
							</td>
							<td>
								<p><a target="_blank" href="#">{{ucfirst($banner->title)}}</a></p>
								<p class="text-muted"><small>{{ucfirst($banner->user->name)}} | {{$banner->created_at->toFormattedDateString()}}</small></p>
								<p>{{substr(strip_tags($banner->content),0,50)}} {{strlen($banner->content) > 50 ? "...": "" }}</p>
							</td>
							<td class="text-center align-middle">{{ucfirst($banner->getGroup())}}</td>
							<td class="text-center align-middle">{!! getStatusIcon($banner->status) !!}</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
									<ul>
										<li class="">
											<a target="_blank" href="" class="btn btn-light disabled" title="Action not allowed"><i class="fas fa-link" aria-hidden="true"></i></a>
										</li>
										<li class="">
											<a href="{{route('banners.edit', $banner->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
										</li>
										<li class="">
											<span id="{{$banner->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
											<form id="delete-form" method="post" action="{{route('banners.destroy', $banner->id)}}">
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
		{{$banners->links()}}
	</div>
</section>
@endsection
