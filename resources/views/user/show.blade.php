@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Users')
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 <a href="">{{trans('main._dashboard')}}</a> > {{trans('main._users')}}</p>
@endsection
@section('add')
<a href=""><span class="fa fa-plus"></span></a>
<a href="{{ URL::previous() }}"><span class="fa fa-chevron-left"></span></a>
@endsection
@section('content')
<div class="container-fluid">  
	<div class="row">
		
			<div class="col-md-3 form-group">
				<!-- side bar -->
				@Include('layouts.partials._user-side-bar')	
			</div>
			<div class="col-md-9 form-group">
				<div class="panel panel-body" id="user-form">
					<div class="row form-padding">
				 	 	<div class="col-md-12"><p>Name: {{$user->name}}</p></div>
				 	 </div>
				 	 <div class="row form-padding">
				 	 	<div class="col-md-12"><p>Email:{{$user->email}}</p></div>
				 	 </div>

					<div class="row form-padding">
				 	 	<div class="col-md-12"><p>gender: {{($user->gender == 1) ? 'Male' : 'Female'}}</p></div>
				 	</div>

				 	 
		

				</div>
			</div>
			
		
		<div class="text-center">
				
		</div>
	</div>     
</div>
@endsection
