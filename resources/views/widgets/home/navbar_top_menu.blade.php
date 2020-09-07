<div class="bg-white" uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">
    <nav class=" bg-white uk-container" uk-navbar>
        {{--Logo--}}
        <div class="uk-navbar-{{getFloatKey((getLanguage() == 'ar')? 'start' : 'end')}}">
            <ul class="uk-navbar-nav navbar-icon-uk" style="margin: 0px 5px">
                <li><a href="#"><img src="{{asset_image(getSite()->logo)}}" style="height: 35px" alt=""></a></li>
                <li class="uk-visible@m site-name" style="">
                    <a class="uk-navbar-item uk-logo navbar-logo" href="{{route('main')}}">
                        <span class="site-name">{{getSite()->name}}</span><span style="color: var(--theme-primary-color);"> &#9679;</span>
                    </a>
                </li>
            </ul>
        </div>
        {{--Top menu--}}
        <div class="uk-visible@m uk-navbar-center">
            <ul class="uk-navbar-nav menu-items">
                @if(!empty($items) && getSite()->active == 1)
                    @foreach($items as $item)
                        <li class="{{(Request::is($item['link'].'*') ? 'uk-active' :'')}}"><a href="{{url($item['link'])}}">{{__($item['title'])}}</a></li>
                    @endforeach
                @endif
            </ul>
            <div class="uk-width-1-1 top-navbar-search" style="display: none">
                <input class="uk-input uk-form-width-large" type="text" placeholder="{{__('main.Search here')}}">
            </div>
        </div>
        {{--User menu--}}
        <div class="uk-navbar-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
            <ul class="uk-navbar-nav">
                <li class="uk-visible@m"><button class="navbar-search uk-text-primary"><span class="search-icon"  uk-icon="icon: search"></span></button></li>
                @if(Auth::check())
                    <li class="uk-visible@m"><a href=""><span uk-icon="cart"></span></a></li>
                    <li class="uk-visible@m"><a href=""><span uk-icon="bell"></span></a></li>
                    <li class="uk-visible@m">
                        <a class="uk-float-right">
                            <span uk-icon="world"></span>
                        </a>
                        <div class="uk-padding-small" uk-dropdown="mode: click">
                            <ul class="uk-list ">
                                <li>
                                    <a href="{{url('lang/ar')}}" class="uk-text-capitalize">
                                        <img class="" src="{{asset_image('/flags/lang-ar-iq.png')}}" style="width: 20px; height: 20px; object-fit: cover; border-radius: 3px; margin: 0px 5px">  <span>{{__('العربية')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('lang/en')}}" class="uk-text-capitalize">
                                        <img class="" src="{{asset_image('/flags/lang-en-uk.png')}}" style="width: 20px; height: 20px; object-fit: cover; border-radius: 3px; margin: 0px 5px">  <span>{{__('english')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <button class="uk-button uk-button-default" type="button" uk-toggle="target: #user-profile-offcanvas-nav">
                            <img class="" src="{{Auth::user()->getProfilePicURL()}}" style="width: 35px; height: 35px; object-fit: cover; border-radius: 5px">
                        </button>
                    </li>
                    <li class="" style="display: none">
                        <div class="uk-padding-small" uk-dropdown>
                            <ul class="uk-list">
                                @if(Auth::user()->hasRole('superadministrator') OR Auth::user()->hasRole('administrator'))
                                    <li><a href="{{route('admin.dashboard')}}" class="uk-text-capitalize"><span class="uk-margin-small-right uk-margin-small-left" uk-icon="tv"></span>{{__('main.manage')}}</a></li>
                                @endif
                                <li><a href="{{route('profile.index')}}" class="uk-text-capitalize"><span class="uk-margin-small-right uk-margin-small-left" uk-icon="user"></span> {{__('main.profile')}}</a></li>
                                <li><a href="{{route('logout')}}" class="uk-text-capitalize"><span class="uk-margin-small-right uk-margin-small-left" uk-icon="sign-out"></span>{{__('main.log out')}}</a></li>
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="uk-visible@m uk-flex uk-flex-middle">
                        <a class="uk-button uk-button-default" href="{{route('login')}}">{{__('main.login')}}</a>
                    </li>
                    {{--                    class="top-menu-login"--}}
                    @if(getSite()->active == 1)
                        <li class="uk-visible@m uk-flex uk-flex-middle">
                            <a class="uk-button uk-button-primary" href="{{route('register')}}">{{__('main.register')}}</a>
                        </li>
                    @endif
                @endif
                <li class="uk-hidden@m">
                    <a class="uk-navbar-toggle" uk-navbar-toggle-icon uk-toggle="target: #top-menu-offcanvas-nav" href="#"></a>
                </li>
            </ul>

        </div>

    </nav>
</div>
{{--<div class="bg-white uk-navbar-container" >--}}
{{--    --}}
{{--</div>--}}

@if(false)
<div class="uk-section-primary uk-preserve-color">

    <div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent uk-light; top: 200">

        <nav class="uk-navbar-container">
            <div class="uk-container uk-container-expand">
                <div uk-navbar>

                    <ul class="uk-navbar-nav">
                        <li class="uk-active"><a href="#">Active</a></li>
                        <li>
                            <a href="#">Parent</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li class="uk-active"><a href="#">Active</a></li>
                                    <li><a href="#">Item</a></li>
                                    <li><a href="#">Item</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">Item</a></li>
                    </ul>

                </div>
            </div>
        </nav>
    </div>

    <div class="uk-section uk-light">
        <div class="uk-container">

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>

            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>

        </div>
    </div>

</div>
@endif

<div id="top-menu-offcanvas-nav" class="uk-light" uk-offcanvas="mode: slide; overlay: true; flip:true">
    <div class="uk-offcanvas-bar">
        @if(!Auth::user())
            <div class="uk-padding-small">
                <a class="uk-button uk-button-default uk-width-1-1 uk-margin-small" href="{{route('login')}}">{{__('main.login')}}</a>
                <a class="uk-button uk-button-primary uk-width-1-1 " href="{{route('register')}}">{{__('main.register')}}</a>
            </div>
        @endif
        <ul class="uk-nav uk-nav-default">
            <li class="uk-nav-header">{{__('main.Main menu')}}</li>
            @if(!empty($items) && getSite()->active == 1)
                @foreach($items as $item)
                    <li class="{{(Request::is($item['link'].'*') ? 'uk-active' :'')}}"><a href="{{url($item['link'])}}">{{__($item['title'])}}</a></li>
                @endforeach
            @endif
        </ul>

    </div>
</div>
@if(Auth::check())
<div id="user-profile-offcanvas-nav" class="uk-light" uk-offcanvas="mode: slide; overlay: true; flip:true">
    <div class="uk-offcanvas-bar">
        <h5 class="text-highlighted uk-text-bold uk-text-primary">{{__('main.User Profile')}}</h5>
        <div class="uk-grid-collapse" uk-grid>
            <div class="uk-width-1-3 uk-flex uk-flex-middle">
                <div>
                    <i class="fas fa-circle uk-text-success online"></i>
                    <img class="" src="{{Auth::user()->getProfilePicURL()}}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px">
                </div>
            </div>
            <div class="uk-width-2-3">
                <p class="uk-text-bold">{{__('main.hi', ['name' => Auth::user()->first_name])}}</p>
                <p>{{Auth::user()->getRole()->display_name}}</p>
                <p>{{Auth::user()->email}}</p>
            </div>
        </div>
        <br>
        <div class="uk-margin">
            @if(Auth::user()->hasRole('superadministrator') OR Auth::user()->hasRole('administrator'))
            <a href="{{route('admin.dashboard')}}">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-1-6 uk-flex uk-flex-middle">
                        <span class="uk-text-success" uk-icon="icon: tv"></span>
                    </div>
                    <div class="uk-width-5-6">
                        <p class="uk-text-bold">{{__('main.manage')}}</p>
                        <p class="uk-text-lighter uk-text-small">{{__('main.Manage your website')}}</p>
                    </div>
                </div>
            </a>
            @endif

            <a href="{{route('profile.index')}}">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-1-6 uk-flex uk-flex-middle">
                        <span class="uk-text-primary" uk-icon="icon: user"></span>
                    </div>
                    <div class="uk-width-5-6">
                        <p class="uk-text-bold">{{__('main.profile')}}</p>
                        <p class="uk-text-lighter uk-text-small">{{__('main.View and modify profile')}}</p>
                    </div>
                </div>
            </a>

            <div class="uk-grid-collapse" uk-grid>
                <div class="uk-width-1-6 uk-flex uk-flex-middle">
                    <span class="uk-text-warning" uk-icon="icon: calendar"></span>
                </div>
                <div class="uk-width-5-6">
                    <p class="uk-text-bold">{{__('main.My Courses')}}</p>
                    <p class="uk-text-lighter uk-text-small">{{__('main.view all of my courses')}}</p>
                </div>
            </div>
        </div>
        <div class="uk-position-bottom uk-padding-small">
            <a class="uk-button uk-button-primary uk-width-1-1" href="{{route('logout')}}"><span uk-icon="icon: sign-out"></span> {{__('main.log out')}}</a>
        </div>
    </div>

</div>
@endif
<script>
    $('.navbar-search').click(function () {
        if (!$('.menu-items').hasClass('hidden')){
            $('.search-icon').attr('uk-icon','icon: close');
            $('.menu-items').addClass('hidden');
            $('.menu-items').slideUp(function () {
                $('.top-navbar-search').slideDown({
                    duration: 50,
                },{
                duration: 50,
                });
            });
        }else {
            $('.search-icon').attr('uk-icon','icon: search');
            $('.menu-items').removeClass('hidden');
            $('.top-navbar-search').slideUp(function () {
                $('.menu-items').slideDown({
                    duration: 50,
                },{
                duration: 50,
                });
            });
        }


    });
</script>
