@if(true)
<!doctype html>
<html lang="en" dir="{{getLanguage() == 'ar'? 'rtl': ''}}">
<head>
    <link rel="icon" href="{{asset_image('/assets/favicon/favicon.ico')}}" type="image/x-icon">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- THEME CSS -->
    <style>
        :root{
            --theme-secondary-bg-color: #F3F5F9;
            --theme-primary-color: {{getFrontEndColor()}};
            --theme-primary-font-color: #949494;
            --text-primary: {{getFrontEndColor()}};
            --text-secondary: #263655;
            --text-success: #17E5B4;
            --text-warning: #faa05a;
            --text-danger: #f0506e;
            --text-regular: #666666;
            --text-highlighted: #263655;
            --bg-secondary: #F9F8FD;
        }

    </style>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">{{--    <!--Semantic UI-->--}}
{{--    <script src="{{asset('libraries/semantic/semantic.min.js')}}"></script>--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('libraries/semantic/semantic.min.css')}}">--}}
    <!--UiKit UI-->
    @if(getLanguage() == 'ar')
        <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit-rtl.min.css')}}"/>
    @else
        <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit.min.css')}}"/>
    @endif
    <!--site Css-->
    <link rel="stylesheet" href="{{url('themes/'.getFrontendThemeName().'/css/general.css?v=202010031900')}}">

    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit-icons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/0disoxw0ri417kacpbbaufwzt6temhwubr87eejae2tyvpjy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <title>{{getSite()->name}} | @yield('title')</title>

@yield('head')

</head>
<body>
{{storeLastUrl()}}
<section style="background-color: var(--bg-secondary);">
    <div class="uk-flex uk-flex-center uk-flex-middle" style="position: fixed;   z-index: 999; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.3); display: none">
        <div class="spinner" style="background-color: white; border-radius: 50%; padding: 10px">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    {{--Navbar--}}
    @widget('home.navbar_top_menu')
    <div class="uk-container">
        @include('partial.frontend._message')
    </div>
    <div style="min-height: calc(100vh - 170px);">
        @yield('content')
    </div>
    <footer style="">
        <div class="uk-child-width-1-1@s uk-text-center" uk-grid>
            <div class="">
                <div class="uk-background-secondary uk-light uk-padding uk-panel">
                    <p class="uk-h5 uk-text-meta">All copy rights served to Tiptopdemy</p>
                </div>
            </div>
        </div>
    </footer >

</section>
<section>
    <div id="login-modal" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h5 class="uk-modal-title">Login</h5>
            </div>
            <div class="uk-modal-body">
                <div uk-grid>
                    <div class="uk-width-3-3@m">
                        <form class="uk-form-stacked" role="form" method="POST" action="{{ route('login.custom') }}">
                            {{ csrf_field() }}

                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                                    <input class="uk-input" name="email" type="text" placeholder="Email">

                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                    <input class="uk-input" type="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <button class="uk-button uk-button-primary uk-width-1-1">log in</button>
                                </div>
                            </div>
                        </form>
                        <div class="uk-text-center">
                            Or, Login with..
                        </div>
                        <div class="uk-margin {{empty( env('FACEBOOK_CLIENT_ID')) ? 'disabled-div' : ''}}">
                            <div class="uk-inline uk-width-1-1">
                                <a href="{{route('login.socialite','facebook')}}" class="uk-button uk-button-primary uk-width-1-1" style="background-color: #3B5998"><span class="uk-margin-small-right" uk-icon="facebook"></span> Facebook</a>
                            </div>
                        </div>
{{--                       --}}
                        <div class="uk-margin {{empty( env('GOOGLE_CLIENT_ID')) ? 'disabled-div' : ''}}">
                            <div class="uk-inline uk-width-1-1">
                                <a href="{{route('login.socialite','google')}}" class="uk-button uk-button-primary uk-width-1-1" style="background-color: #D34836"><span class="uk-margin-small-right" uk-icon="google"></span> Google</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="screen-spinner uk-flex uk-flex-center uk-flex-middle" style="position: fixed; top: 0px; z-index: 1000; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.3); display: none">
        <div style="padding: 20px; background-color: rgba(255, 255, 255, 0.7); border-radius: 5px">
            <div class="uk-text-primary" uk-spinner="ratio: 2"></div>
        </div>
    </div>
</section>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    @if(getAuthUser() && getSite()->active == 0)
    var offlineMessage = '{{__('main.Website is currently offline.')}}'
    UIkit.notification("<span uk-icon='icon: warning'></span> "+offlineMessage, {pos: 'top-center', status:'warning'})
    @endif
    function toggleScreenSpinner($status = true)
    {
        if($status === true){
            $('.screen-spinner').fadeIn();
        }else {
            $('.screen-spinner').fadeOut();
        }
    }
    $('.pagination').addClass('uk-pagination').addClass('uk-flex-center');

    $('.top-menu-login').click(function () {
        UIkit.modal('#login-modal').show();
    });
    function enableLoadingSpinner($status = true) {
        if($status === true){
            $('.loading-screen-spinner').fadeIn();
        } else{
            $('.loading-screen-spinner').fadeOut();
        }
    }
</script>

</body>
</html>
@endif