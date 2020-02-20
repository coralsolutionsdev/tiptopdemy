<nav class="my-nav navbar navbar-expand-lg">
  <div class="container-fluid row">
  	<div id="search" class="col-6">
  		<form>
  		<button><i class="fa fa-search" aria-hidden="true"></i>
		</button>
  		<input id="search" type="text" name="search" placeholder="search here ...">
  		</form>
  	</div>
  	<div class="col-6 d-flex justify-content-end">
  		<ul class="navbar-nav">
  			<li class="nav-item"><a href="" class="nav-link"><i class="fa fa-bell-o" aria-hidden="true"></i></a></li>
  			<li class="nav-item"><a href="" class="nav-link"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>

	        <li id="lang" class="nav-item dropdown">
	          <a class="nav-link " href="http://example.com" id="ChooseLanguageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	            <i class="fa fa-globe" aria-hidden="true"></i>
	          </a>
	          <div class="dropdown-menu" aria-labelledby="ChooseLanguageDropdown">
	            <a class="dropdown-item" href="/lang/ar">AR</a>
	            <a class="dropdown-item" href="/lang/en">EN</a>
	          </div>
	         </li>

	         <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		            {{ Auth::user()->name }}
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
		            <a class="dropdown-item" href="{{ route('home') }}#">{{trans('main._profile')}}</a>
		            <div class="dropdown-divider"></div>
		            <a class="dropdown-item" href="{{ route('logout') }}"
		                                              onclick="event.preventDefault();
		                                                       document.getElementById('logout-form').submit();">{{trans('main._logout')}}</a>
		                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		                                              {{ csrf_field() }}
		                                          </form>
		          </div>
		        </li>
		        <li class="nav-item"><img src="{{asset('/uploads/profile/avatars/'.Auth::user()->avatar)}}" height="35" class="rounded-circle avatar"></li>
		        <li>&nbsp&nbsp</li>
		        <li class="nav-item"><a target="_blank" href="{{ route('main') }}" class="nav-link"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a></li>
	    </ul>
  	</div>
  </div>
</nav>