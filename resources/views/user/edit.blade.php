@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._users'))
@section('page-header-button')
@endsection
@section('content')

<section>
	@include('manage.partials._page-header')
	<div class="form-panel row">
		<div class="col-lg-12">
			<div class="row col-lg-12 padding-0 margin-0">

				<div class="col-lg-3 image-upload-rtl">
					<div class="card border-light" style="min-height: 350px">
						<div class="card-body">
							<div class="text-center">
								<img id="output" src="{{$user->getProfilePicURL()}}" class="profile-picture w-180">
								<span class="btn btn-primary browse-files" style="cursor: pointer; margin: 10px; min-width: 75px"><i class="far fa-image"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9 properties-rtl">
					<div class="card border-light" style="min-height: 350px">
						<div class="card-body user-profile">
							<ul class="nav nav-pills mb-3 padding-0 margin-0" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Basic Info')}}</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Password')}}</a>
								</li>
							</ul>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
									{!! Form::open(['url' => route('users.update', $user->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Name')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											{!! Form::text('name',(!empty($user))? $user->name:'',['class' => 'form-control title','required' => true,'placeholder' => 'User name']) !!}
										</div>
									</div>
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Email')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											{!! Form::text('email',(!empty($user))? $user->email:'',['class' => 'form-control title','required' => true,'placeholder' => 'User email']) !!}
										</div>
									</div>
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Gender')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											<select name="gender" id="gender" class="custom-select col-12 form-control-dropdown">
												<option value="1"{{($user->gender == 1)?'selected':''}}>{{trans('main._male')}}</option>
												<option value="0"{{($user->gender == 0)?'selected':''}}>{{trans('main._female')}}</option>
											</select>
										</div>
									</div>
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Role')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											<select name="role" id="gender" class="custom-select col-12 form-control-dropdown">
												@foreach($roles as $item)
													<option value="{{$item->id}}"{{($user->hasRole($item->name))?'selected':''}}>{{$item->display_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Registration')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											<input type="checkbox" name="status" class="toogle-switch" value="1" {{($user->status == 1)? 'checked':''}}>
										</div>
									</div>
									<div class="text-right">
										<button class="btn btn-primary">Submit</button>
										{!! Form::file('image', ['id' => 'attachments-upload', 'style' => 'display:none', 'accept' => "application/zip, application/x-7z-compressed, application/x-rar-compressed, image/x-png, image/jpeg, image/png, application/pdf, application/msword, video/*, image/*, audio/*", 'multiple' => true]) !!}
									</div>
									{!! Form::close() !!}
								</div>
								<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
									{!! Form::open(['url' => route('users.update', $user->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Password')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											<input type="password" name="password" class="form-control" placeholder="Password">
										</div>
									</div>
									<div class="form-group row col-lg-12 padding-0 margin-0">
										<div class="col-lg-2 d-flex align-items-center padding-0">{{__('Confirm Password')}}</div>
										<div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
											<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
										</div>
									</div>
									<div class="text-right">
										<button class="btn btn-primary">Submit</button>
									</div>
									{!! Form::close() !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{{--	{!! Form::close() !!}--}}

</section>
@if(false)
			<form method="POST" action="{{route('users.update', $user->id)}}" enctype="multipart/form-data" data-parsley-validate>
				{{csrf_field()}} {{method_field('PUT')}}
				<section class="page-header">
					<div class="row">
						<div class="col-md-6">
							<h2>@yield('title')</h2>
							<small><p class="text-muted">{{trans('main._home')}} / {{trans('main._posts')}} / {{trans('main._add')}}</p></small>
						</div>
						<div class="col-md-6 d-flex justify-content-end">
							<div class="col-5">
								<button type="submit" name="submit" class="btn {{(!empty($user))? ' btn-success':' btn-primary'}} btn-lg col-12" >{{(!empty($plan))? trans('main._update'): trans('main._submit')}}</button>
							</div>
						</div>
					</div>
				</section>
				<section class="container-fluid">
					<div class="row col-sm-12">
						<div class="col-sm-8">
							<div class="card border-light">
								<div class="card-body">

									<!--form item-->
									<div class="form-group d-flex align-items-center">
										<div class="col-md-2">
											<label>Name</label>
										</div>
										<div class="col-md-8">
											<input type="text" name="name" class="form-control" value="{{(!empty($user))? $user->name:''}}" required>
										</div>
									</div>
									<!--form item-->
									<div class="form-group d-flex align-items-center">
										<div class="col-md-2">
											<label>Email</label>
										</div>
										<div class="col-md-8">
											<input type="text" name="email" class="form-control" value="{{(!empty($user))? $user->email:''}}" required>
										</div>
									</div>
									<!--form item-->
									<div class="form-group d-flex align-items-center">
										<div class="col-md-2">
											<label>Gender</label>
										</div>
										<div class="col-md-8">
											<select name="gender" id="gender" class="custom-select col-12 form-control-dropdown">
												<option value="1"{{($user->gender == 1)?'selected':''}}>{{trans('main._male')}}</option>
												<option value="0"{{($user->gender == 0)?'selected':''}}>{{trans('main._female')}}</option>
											</select>
										</div>
									</div>
									<!--form item-->
									<div class="form-group d-flex align-items-center">
										<div class="col-md-2">
											<label>Role</label>
										</div>
										<div class="col-md-8">
											<select name="role" id="gender" class="custom-select col-12 form-control-dropdown">
												@foreach($roles as $item)
													<option value="{{$item->id}}"{{($user->hasRole($item->name))?'selected':''}}>{{$item->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<!--form item-->
									<div class="form-group d-flex align-items-center">
										<div class="col-md-2">
											<label>{{trans('main._status')}}:</label>
										</div>
										<div class="col-md-10">
											<input type="checkbox" name="status" class="toogle-switch" value="1" {{($user->status == 1)? 'checked':''}}>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="card border-light">
								<div class="card-body text-center" >
									<div>
										<img src="{{asset('/uploads/profile/avatars/'.$user->avatar)}}" height="200" class="rounded-circle">
									</div>
									<div class="card-body">
										<h3>{{$user->name}}</h3>
										<p>{{$user->getGender()}}</p>
										<p>{{$user->getRole()->display_name}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</form>
@endif

@endsection
@section('script')
	<script>
		$('.drag-area,.browse-files,.image-area').click(function()
		{
			$('#attachments-upload').click();
		});
		$('#attachments-upload').change(function(event)
		{
			$('.drag-area').slideUp();
			var reader = new FileReader();
			reader.onload = function(){
				var output = document.getElementById('output');
				output.src = reader.result;
			};
			reader.readAsDataURL(event.target.files[0]);
		});
	</script>
@endsection
