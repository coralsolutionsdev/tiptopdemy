@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._menus'))
@section('page-header-button')
	<a href="{{Route('menus.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
						<th scope="col" width="50">{{__('Title')}}</th>
						<th scope="col" class="text-center">{{__('position')}}</th>
						<th scope="col" class="text-center" width="100">{{__('items count')}}</th>
						<th scope="col" class="text-center" width="50">{{__('status')}}</th>
						<th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($menus as $menu)
						<tr>
							<td class="align-middle">{{$menu->title}}</td>
							<td class="text-center align-middle">{{\App\Menu::POSITIONS_ARRAY[$menu->position]}}</td>
							<td class="text-center align-middle">{{count($menu->items)}}</td>
							<td class="text-center align-middle">{!! getStatusIcon($menu->status) !!}</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
									<ul>
										<li class="">
											<a target="_blank" href="" class="btn btn-light disabled"><i class="fas fa-link" aria-hidden="true"></i></a>
										</li>
										<li class="">
											<a href="{{route('menus.edit', $menu->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
										</li>
										<li class="">
											<span id="{{$menu->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
											<form id="delete-form" method="post" action="{{route('menus.destroy', $menu->id)}}">
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
		{{$menus->links()}}
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

{{--				@foreach ($menus as $menu)--}}
{{--				<tr>--}}
{{--					<td class="align-middle">{{$menu->id}}</td>--}}
{{--					--}}
{{--					<td class="align-middle">{{$menu->title}}</td>--}}
{{--					<td class="align-middle">{{$menu->order_id}}</td>--}}
{{--					<td class="align-middle text-center">{{$menu->position}}</td>--}}
{{--					<td id="status" class="text-center align-middle">--}}
{{--					@if($menu->status == "1")--}}
{{--						<span class="fa fa-check-circle-o text-success" aria-hidden="true"></span>--}}
{{--					@else--}}
{{--						<span class="fa fa-times-circle-o text-danger" aria-hidden="true"></span>--}}
{{--					@endif--}}
{{--					</td>--}}
{{--					<td class="align-middle text-center">{{$menu->user->name}}</td>--}}
{{--					<td style="width: 100px;">--}}
{{--						<div id="action_btn">--}}
{{--							<nav class="navbar navbar-expand-lg">--}}
{{--								<ul class="navbar-nav">--}}
{{--									<li class="nav-item">--}}
{{--										<a href="{{route('menus.edit', $menu->id)}}" class="nav-link btn btn-light"><i class="far fa-edit" ></i></a>--}}
{{--									</li>--}}
{{--									<li id="delete_btn" class="nav-item">--}}
{{--										<form class="" method="post" action="{{route('menus.destroy', $menu->id)}}">--}}
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
