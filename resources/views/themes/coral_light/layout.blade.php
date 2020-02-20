<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- THEME CSS -->
    <style>
        :root{
            --theme-primary-color: {{getFrontEndColor()}};
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=DM+Sans|Lobster|Rubik|Squada+One&display=swap" rel="stylesheet"><!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/css/uikit.min.css" />
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{url('themes/'.getFrontendThemeName().'/css/general.css')}}">

    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit-icons.min.js"></script>
    <script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/0disoxw0ri417kacpbbaufwzt6temhwubr87eejae2tyvpjy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script src="{{ asset('js/parallax.js') }}"></script>
    <title>{{getSite()->name}} | @yield('title')</title>

@yield('head')

</head>
<body>
{{storeLastUrl()}}
<section>
    <div class="uk-flex uk-flex-center uk-flex-middle" style="position: fixed;   z-index: 999; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.3); display: none">
        <div class="spinner" style="background-color: white; border-radius: 50%; padding: 10px">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    {{--Navbar--}}
    @widget('home.navbar_top_menu')
    @yield('content')
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
                                    <input class="uk-input" id="form-stacked-text" name="email" type="text" placeholder="Email">

                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                    <input class="uk-input" id="form-stacked-text" type="password" name="password" placeholder="Password">
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
<script>
    $('.pagination').addClass('uk-pagination').addClass('uk-flex-center');

    $('.top-menu-login').click(function () {
        UIkit.modal('#login-modal').show();
    });
</script>

</body>
</html>