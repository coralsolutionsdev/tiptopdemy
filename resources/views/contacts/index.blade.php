@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._menus'))
@section('page-header-button')
	<a href="{{Route('contacts.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
							<th scope="col">{{__('Title')}}</th>
							<th scope="col" class="text-center" width="200">{{__('items count')}}</th>
							<th scope="col" class="text-center" width="200">{{__('status')}}</th>
							<th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($contacts as $item)
							<tr>
								<td class="align-middle">{{$item->title}}</td>
								<td class="text-center align-middle">{{count($item->items)}}</td>
								<td class="text-center align-middle">{!! getStatusIcon($item->status) !!}</td>
								<td>
									<div class="action_btn text-right" style="padding-top: 10px">
										<ul>
											<li class="">
												<a target="_blank" href="" class="btn btn-light disabled"><i class="fas fa-link" aria-hidden="true"></i></a>
											</li>
											<li class="">
												<a href="{{route('contacts.edit', $item->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
											</li>
											<li class="">
												<span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
												<form id="delete-form" method="post" action="{{route('contacts.destroy', $item->id)}}">
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
			{{$contacts->links()}}
		</div>
	</section>


	{{--<div class="row card border-light">--}}
	{{--		--}}
	{{--		<table class="table table-hover" id="blog-table">--}}
	{{--			<thead>--}}
	{{--				<th>#</th>--}}
	{{--		     	<th>{{trans('main._title')}}</th>--}}
	{{--		     	<th>{{trans('main._order_id')}}</th>--}}
	{{--		      	<th class="text-center">{{trans('main._position')}}</th>--}}
	{{--		      	<th class="text-center">{{trans('main._status')}}</th>--}}
	{{--		      	<th class="text-center">{{trans('main._user')}}</th>--}}
	{{--		      	<th class="text-center">{{trans('main._actions')}}</th>--}}
	{{--			</thead>--}}
	{{--			<tbody>--}}

	{{--				@foreach ($items as $item)--}}
	{{--				<tr>--}}
	{{--					<td class="align-middle">{{$item->id}}</td>--}}
	{{--					--}}
	{{--					<td class="align-middle">{{$item->title}}</td>--}}
	{{--					<td class="align-middle">{{$item->order_id}}</td>--}}
	{{--					<td class="align-middle text-center">{{$item->position}}</td>--}}
	{{--					<td id="status" class="text-center align-middle">--}}
	{{--					@if($item->status == "1")--}}
	{{--						<span class="fa fa-check-circle-o text-success" aria-hidden="true"></span>--}}
	{{--					@else--}}
	{{--						<span class="fa fa-times-circle-o text-danger" aria-hidden="true"></span>--}}
	{{--					@endif--}}
	{{--					</td>--}}
	{{--					<td class="align-middle text-center">{{$item->user->name}}</td>--}}
	{{--					<td style="width: 100px;">--}}
	{{--						<div id="action_btn">--}}
	{{--							<nav class="navbar navbar-expand-lg">--}}
	{{--								<ul class="navbar-nav">--}}
	{{--									<li class="nav-item">--}}
	{{--										<a href="{{route('menus.edit', $item->id)}}" class="nav-link btn btn-light"><i class="far fa-edit" ></i></a>--}}
	{{--									</li>--}}
	{{--									<li id="delete_btn" class="nav-item">--}}
	{{--										<form class="" method="post" action="{{route('menus.destroy', $item->id)}}">--}}
	{{--											{{csrf_field()}}--}}
	{{--											{{method_field('DELETE')}}--}}
	{{--											<button type="submit"><span class="far fa-trash-alt btn btn-light"></span></button>--}}
	{{--										</form>--}}
	{{--									</li>--}}
	{{--									--}}
	{{--								</ul>--}}
	{{--							</nav>--}}
	{{--						</div>--}}
	{{--					</td>--}}
	{{--				</tr>--}}
	{{--				@endforeach--}}

	{{--			</tbody>--}}
	{{--			--}}
	{{--		</table>--}}

	{{--</div>       --}}

@endsection
