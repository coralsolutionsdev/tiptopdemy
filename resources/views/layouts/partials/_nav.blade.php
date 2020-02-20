<nav class="my-nav navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    @if(!empty(getSite()->logo and getSite()->logo_show))
    <a class="navbar-brand" href="{{ route('main') }}">
        <img src="{{asset('/uploads/logo/'.getSite()->logo)}}" class="rounded-circle avatar">
    </a>
    @else
    <a class="navbar-brand" href="{{ route('main') }}">
    {{getSite()->name}}
    </a>
    @endif

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <div class="col">
        <ul class="navbar-nav">
        <li class="nav-item ">
          <a class="nav-link {{Request::is('/') ? "active" : ""}}" href="/">{{trans('main._home')}}</span></a>
        </li>
        
        @foreach(getTopMenu() as $menu)
            @if($menu->position == 'header' or $menu->position == 'header-footer')
                <li class="text-capitalize">
                    <a class="nav-link {{Request::is($menu->link .'*') ? "active" : ""}}" href="{{ URL::asset($menu->link) }}" href="{{ URL::asset($menu->link) }}">{{$menu->title}}</a>
                </li>
            @endif
        @endforeach
        
      </ul>
      </div>
      
      <div class="col d-flex justify-content-end">
          
        <ul class="navbar-nav">
          @if (Auth::User())
          
          <li class="nav-item"><a href="" class="nav-link"><i class="fa fa-bell-o" aria-hidden="true"></i></a></li>
          <li class="nav-item"><a href="" class="nav-link"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
              
          @endif
          <!--
          <li id="lang" class="nav-item dropdown d-none d-sm-block">
          <a class="nav-link " href="http://example.com" id="ChooseLanguageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-globe" aria-hidden="true"></i>
          </a>
          
          <div class="dropdown-menu" aria-labelledby="ChooseLanguageDropdown">
            <a class="dropdown-item" href="/lang/ar">AR</a>
            <a class="dropdown-item" href="/lang/en">EN</a> 
          </div>
          </li>
          -->
          @if (Auth::guest())
          <!--
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user-circle-o" aria-hidden="true"></i>
              </a></li>
            -->         
          @else
        <li class="nav-item dropdown d-none d-sm-block">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            @if (Auth::user()->role == 'admin')
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{trans('main._admin_dashboard')}}</a>
            @endif
            <a class="dropdown-item" href="{{ route('home') }}">{{trans('main._profile')}}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}"
                                              onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">{{trans('main._logout')}}</a>
                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              {{ csrf_field() }}
                                          </form>
          </div>
        </li>
        <li class="nav-item d-none d-sm-block d-md-block"><img src="{{asset('/uploads/profile/avatars/'.auth::user()->avatar)}}" class="rounded-circle avatar"></li>
        @endif
       
        </ul>
      </div>
    </div>
  </div>
</nav>