<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">

    <nav class="navbar uk-navbar-container" uk-navbar style="position: relative; z-index: 980;">

        <div class="uk-navbar-left">

            <a class="uk-navbar-item uk-logo navbar-logo" href="{{route('main')}}">
                <span>{{getSite()->name}}</span><span style="color: var(--theme-primary-color);"> &#9679;</span>
            </a>

        </div>

        <div class="uk-navbar-center">

            <ul class="uk-navbar-nav menu-items">
                @if(!empty($items) && getSite()->active == 1)
                    @foreach($items as $item)
                        <li class="{{(Request::is($item['link'].'*') ? 'uk-active' :'')}}"><a href="{{url($item['link'])}}">{{$item['title']}}</a></li>
                    @endforeach
                @endif
{{--                                <li>--}}
{{--                                    <a href="#">Parent</a>--}}
{{--                                    <div class="uk-navbar-dropdown">--}}
{{--                                        <ul class="uk-nav uk-navbar-dropdown-nav">--}}
{{--                                            <li class="uk-active"><a href="#">Active</a></li>--}}
{{--                                            <li><a href="#">Item</a></li>--}}
{{--                                            <li><a href="#">Item</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                <li><a href="#">Blog</a></li>--}}
{{--                <li><a href="#">Gallery</a></li>--}}
{{--                <li><a href="#">Contact us</a></li>--}}
            </ul>
            <div class="uk-width-1-1 top-navbar-search" style="display: none">
                <input class="uk-input uk-form-width-large" type="text" placeholder="Search here">
            </div>

        </div>

        <div class="uk-navbar-right">

            <ul class="uk-navbar-nav">
                @if(Auth::check())

                    <li><a href=""><span uk-icon="cart"></span></a></li>
                    <li><a href=""><span uk-icon="bell"></span></a></li>
                    <li>
                        <button class="uk-button uk-button-default bottom-left" type="button">
                            <img class="uk-border-circle" src="{{Auth::user()->getProfilePicURL()}}" style="width: 35px; height: 35px; object-fit: cover" >
                        </button>
                        <div class="uk-padding-small" uk-dropdown>
                            <ul class="uk-list">
                                @if(Auth::user()->hasRole('superadministrator') OR Auth::user()->hasRole('administrator'))
                                <li><a href="{{route('admin.dashboard')}}"><span class="uk-margin-small-right" uk-icon="tv"></span> Manage</a></li>
                                @endif
                                <li><a href=""><span class="uk-margin-small-right" uk-icon="user"></span> Profile</a></li>
                                <li><a href="{{route('logout')}}"><span class="uk-margin-small-right" uk-icon="sign-out"></span> Log out</a></li>
                            </ul>
                        </div>
                    </li>
                @else
                    <li><button class="top-menu-login">Login</button></li>
                    @if(getSite()->active == 1)
                        <li><a href="{{route('register')}}">Get started</a></li>
                    @endif
                @endif
                    <li><button class="navbar-search uk-text-primary"><span class="search-icon"  uk-icon="icon: search"></span></button></li>
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
                $('.top-navbar-search').slideDown();
            });
        }else {
            $('.search-icon').attr('uk-icon','icon: search');
            $('.menu-items').removeClass('hidden');
            $('.top-navbar-search').slideUp(function () {
                $('.menu-items').slideDown();
            });
        }


    });
</script>
