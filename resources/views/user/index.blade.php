@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._users'))
@section('page-header-button')
@Include('layouts.partials.modals._add_new_user')
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
						<th scope="col">{{trans('main._avatar')}}</th>
						<th scope="col">{{trans('main._name')}}</th>
						<th scope="col">{{trans('main._email')}}</th>
						<th scope="col">{{trans('main._gender')}}</th>
						<th scope="col">{{trans('main._role')}}</th>
						<th scope="col" class="text-center">{{trans('main._actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($users as $user)
						@if($user->getRole()->name != 'superadministrator' || $current_user->isSuperAdmin())
							<tr>
								<td class="align-middle"><img src="{{$user->getProfilePicURL()}}" class="profile-picture-w-50"></td>
								<td class="align-middle"><a href="" target="_balnk">{{ucfirst($user->name)}}</a><br><small class="uk-text-muted">{{$user->username}}</small></td>
								<td class="align-middle">{{$user->email}}</td>
								<td class="align-middle">{{($user->gender == 1 ) ? trans('main._male') : trans('main._female')}}</td>
								<td class="align-middle"> {{$user->getRole()->display_name}}</td>
								<td>
									<div class="action_btn text-right" style="padding-top: 10px">
										<ul>
{{--											<li class="">--}}
{{--												<a target="_blank" href="{{route('profile.show', $user->id)}}" class="btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>--}}
{{--											</li>--}}
											<li class="">
												<a href="{{route('users.edit', $user->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
											</li>
											<li class="">
												<span id="{{$user->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
												<form id="delete-form" method="post" action="{{route('users.destroy', $user->id)}}">
													{{csrf_field()}}
													{{method_field('DELETE')}}
												</form>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						@endif
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div>
		{{$users->links()}}
		</div>
</section>

@if(false)
<section class="page-header">
    <div class="row">
        <div class="col-md-6">
        	<h2>@yield('title')</h2>
            <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._users')}}</p></small>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
			<div class="col-5">
			@Include('layouts.partials.modals._add_new_user')
			</div>        
		</div>
    </div>
</section>
<div class="row card border-light">
		<table class="table table-hover">
			<thead>
				
				<th>#</th>
				<th>{{trans('main._avatar')}}</th>
				<th>{{trans('main._name')}}</th>
				<th>{{trans('main._email')}}</th>
				<th>{{trans('main._gender')}}</th>
				<th>{{trans('main._role')}}</th>
				<th class="text-center">{{trans('main._actions')}}</th>
			</thead>
			<tbody>
				@foreach ($users as $user)
					@if($user->getRole()->name != 'superadministrator' OR $current_user->isSuperAdmin())
						<tr>
					<td class="align-middle">{{$user->id}}</td>
					<td><img src="{{asset('/uploads/profile/avatars/'.$user->avatar)}}" height="50" class="rounded-circle avatar-50"></td>
					<td class="align-middle"><a href="{{route('profile.show', $user->id)}}" target="_balnk">{{ucfirst($user->name)}}</td>
					<td class="align-middle">{{$user->email}}</td>
					<td class="align-middle">{{($user->gender == 1 ) ? trans('main._male') : trans('main._female')}}</td>
					<td class="align-middle"> {{$user->getRole()->display_name}}</td>
					
					<td  style="width: 100px;">
						<div id="action_btn">
							<nav class="navbar-expand-lg">
								<ul class="navbar-nav">
									<li class="">
										<a target="_blank" href="{{route('profile.show', $user->id)}}" class="nav-link btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>
									</li>
									<li class="nav-item">
										<a href="{{route('users.edit', $user->id)}}" class="nav-link btn btn-light"><i class="far fa-edit"></i></a>
									</li>
									<li id="delete_btn" class="nav-item">
										<form class="" method="post" action="{{route('users.destroy', $user->id)}}">
											{{csrf_field()}}
											{{method_field('DELETE')}}
											<button type="submit"><span class="far fa-trash-alt btn btn-light" aria-hidden="true"></span></button>
										</form>
									</li>
								</ul>
							</nav>
						</div>
					</td>
				</tr>
					@endif
				@endforeach
			</tbody>
			
		</table>
	
</div>       
<div class="text-center">
	<div class="d-flex justify-content-center pagination">
		{!!$users->render()!!}
	</div>
</div>
@endif
@endsection
