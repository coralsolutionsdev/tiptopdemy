<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">

    <nav class="nav uk-navbar-container" uk-navbar style="position: relative; z-index: 980;">

        <div class="uk-navbar-{{getFloatKey((getLanguage() == 'ar')? 'start' : 'end')}}">
            <img src="{{asset_image(getSite()->logo)}}" style="height: 35px" alt="">
            <a class="uk-navbar-item uk-logo navbar-logo" href="{{route('main')}}">
                <span class="site-name">{{getSite()->name}}</span><span style="color: var(--theme-primary-color);"> &#9679;</span>
            </a>
        </div>

        <div class="uk-navbar-center">
            <ul class="uk-navbar-nav menu-items">
                @if(!empty($items) && getSite()->active == 1)
                    @foreach($items as $item)
                        <li class="{{(Request::is($item['link'].'*') ? 'uk-active' :'')}}"><a href="{{url($item['link'])}}">{{__($item['title'])}}</a></li>
                    @endforeach
                @endif
            </ul>
            <div class="uk-width-1-1 top-navbar-search" style="display: none">
                <input class="uk-input uk-form-width-large" type="text" placeholder="Search here">
            </div>
        </div>

        <div class="uk-navbar-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
            <ul class="uk-navbar-nav">
                <li><button class="navbar-search uk-text-primary"><span class="search-icon"  uk-icon="icon: search"></span></button></li>
                <li>
                        <a class="uk-float-right">
                            <span uk-icon="world"></span>
                        </a>
                        <div class="uk-padding-small" uk-dropdown>
                            <ul class="uk-list ">
                                <li><a href="{{url('lang/ar')}}" class="uk-text-capitalize">
                                        <span>{{__('العربية')}}</span>
                                    </a>
                                </li>
                                <li><a href="{{url('lang/en')}}" class="uk-text-capitalize">
                                        <span>{{__('english')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
            </li>
                @if(Auth::check())
                    <li><a href=""><span uk-icon="cart"></span></a></li>
                    <li><a href=""><span uk-icon="bell"></span></a></li>
                    <li>
                        <button class="uk-button uk-button-default uk-float-left" type="button">
                            <img class="uk-border-circle" src="{{Auth::user()->getProfilePicURL()}}" style="width: 35px; height: 35px; object-fit: cover">
                        </button>
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
                    <li><a href="{{route('login')}}">{{__('login')}}</a></li>
                    {{--                    class="top-menu-login"--}}
                    @if(getSite()->active == 1)
                        <li><a href="{{route('register')}}">{{__('get started')}}</a></li>
                    @endif
                @endif
            </ul>

        </div>

    </nav>
</div>
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
