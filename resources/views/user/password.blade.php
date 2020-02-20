@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Users')
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 <a href="">Dashboard</a> > Users</p>
@endsection
@section('add')
<a href=""><span class="fa fa-plus"></span></a>
<a href="{{ URL::previous() }}"><span class="fa fa-chevron-left"></span></a>
@endsection
@section('content')
<div class="container-fluid">  
	<div class="row">
		<form method="POST" action="{{route('password.update', $user->id)}}" enctype="multipart/form-data" data-parsley-validate>
	        {{csrf_field()}} {{method_field('PUT')}}
			<div class="col-md-3 form-group">
				<!-- side bar -->
				@Include('layouts.partials._user-side-bar')
			</div>
			<div class="col-md-9 form-group">
				<div class="panel panel-body" id="user-form">
					<p>Pssword Update</p>
					<p>{{$user->name}}</p>
					<div class="row form-padding">
				 	 	<div class="col-md-12"><p>Password:</p></div>
				 	 	<div>
				 	 		<div class="col-md-6">
								<input type="password" name="password" class="form-control" placeholder="Password">
							</div>
				 	 	</div>
				 	 </div>
				 	 <div class="row form-padding">
				 	 	<div>
				 	 		<div class="col-md-6">
								<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
							</div>
				 	 	</div>
				 	 </div>

				 	 <div>
				 	 	
				 	 	<div class="col-md-2"><button type="submit" name="submit" class="btn btn-primary col-md-12" >Submit</button></div>
				 	 
				 	 </div>

				
				</div>
			</div>
			
		
		<div class="text-center">
				
		</div>
	</form>       
	</div>       
</div>
@endsection
