<!doctype html>
<html lang="{{getLanguage()}}" dir="{{getLanguage() == 'ar'? 'rtl': ''}}">
<head>
    <!-- ... -->
    <title>{{getSite()->name}} | @yield('title')</title>
    <link rel="icon" href="{{asset_image('/assets/favicon/favicon.ico')}}" type="image/x-icon">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
{{--    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit.min.css')}}"/>
    <!--site Css-->
    <link rel="stylesheet" href="{{asset('themes/'.getFrontendThemeName().'/css/general.css?v=202105012232')}}">

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
            <!---->
            /*--vs-primary: 91, 60, 196;*/
            /*--vs-success: 23, 201, 100*/
            /*--vs-danger: 242, 19, 93*/
            /*--vs-warn: 254, 130, 0*/
            /*--vs-dark: 36, 33, 69*/
        }
    </style>

    <!-- all scripts -->
    <!-- scripts -->
    <script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
    <!-- scripts -->
    <script src="{{asset('libraries/uikit/js/uikit.min.js')}}"></script>
    <script src="{{asset('libraries/uikit/js/uikit-icons.min.js')}}"></script>
    <script src="{{asset('themes/'.getFrontendThemeName().'/js/app.js?v=202105012232')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')
</head>
<body>
<div class="uk-child-width-1-1@s uk-grid-collapse" uk-grid style="background-color: var(--bg-secondary);">
    <div>
        @widget('home.navbar_top_menu')
        <div class="uk-container">
            @include('partial.frontend._message')
        </div>
    </div>
    <div style="min-height: calc(100vh - 170px);">
        <div id="vue-app">
            @yield('content')
        </div>
    </div>
    <div>
        <div class="">
            <div class="uk-background-secondary uk-light uk-padding uk-panel uk-text-center">
                <p class="uk-h5 uk-text-meta uk-margin-small">All copy rights served to tiptopdemy.com © {{date('Y')}}</p>
            </div>
        </div>
    </div>
</div>

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v10.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
     attribution="page_inbox"
     page_id="103810867929225">
</div>
@include('partial.frontend._loading')
<script src="{{asset('js/app.js?v=202105012232')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".birthday").flatpickr();
</script>
</body>
</html>