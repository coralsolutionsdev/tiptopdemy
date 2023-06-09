@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
	<a href="{{Route('pages.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
						<th scope="col">{{__('Page')}}</th>
						<th scope="col" class="text-center">{{__('Url')}}</th>
						<th scope="col" class="text-center">{{__('Status')}}</th>
						<th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($institutions as $item)
						<tr>
							<td style="width: 120px">
								<img src="{{getImageURL($item->image)}}" style="width: 100%">
							</td>
							<td>
								<p><a target="_blank" href="{{route('get.page', $item->slug)}}">{{ucfirst($item->title)}}</a></p>
								<p class="text-muted"><small>{{ucfirst($item->user->name)}} | {{$item->created_at->toFormattedDateString()}}</small></p>
								<p>{{substr(strip_tags($item->body),0,50)}} {{strlen($item->body) > 50 ? "...": "" }}</p>
							</td>
							<td class="text-center align-middle">{{ucfirst($item->slug)}}</td>
							<td class="text-center align-middle">{!! getStatusIcon($item->status) !!}</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
									<ul>
										<li class="">
											<a target="_blank" href="{{route('get.page', $item->slug)}}" class="btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>
										</li>
										<li class="">
											<a href="{{route('pages.edit', $item->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
										</li>
										<li class="">
											<span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
											<form id="delete-form" method="post" action="{{route('pages.destroy', $item->id)}}">
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
		{{$institutions->links()}}
	</div>
</section>
@endsection
