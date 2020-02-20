<div class="row">
	<div class="text-center" style="background-color: #fff;"> 
	<div><img src="{{asset('/uploads/profile/cover/default-cover.jpg')}}" width="100%" class="cover-picture"></div>
	<div><img src="{{asset('/uploads/avatars/'.$user->avatar)}}" class="user-page-profile-pic"></div>
	<div>{{$user->name}}</div>
	<div>{{$user->role}}</div>
	<div><p>{{'@mehmetmunaf'}}</p></div>
	<div style="width: 60%; float: none; margin: auto;">{{'"I would rather have a mind opened by wonder than one closed by belief."'}}</div>
	</div>
</div>
<div>
	<br>
</div>
<div class="row">
	<div class="list-group">
	  <a href="{{route('users.edit', $user->id)}}" class="list-group-item">Profile</a>
	  <a href="{{route('password.edit', $user->id)}}" class="list-group-item">Password</a>
	  <a href="{{route('role.edit', $user->id)}}" class="list-group-item">Role</a>
	  
	</div>
</div>