<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=0">

<title>{{getSite()->name}} | @yield('title')</title>

<!-- Bootstrap CSS -->
<!-- Uikit Css-->
<!-- Direction -->
@if(auth()->user())
    @if(auth()->user()->lang == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap/rtl/bootstrap-rtl.css') }}">
    @endif
@else
    @if(session('lang') == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap/rtl/bootstrap-rtl.css') }}">
    @else
        @if(!session()->has('lang') and getSite()->lang == 'ar')
            <link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap/rtl/bootstrap-rtl.css') }}">
        @endif
    @endif
@endif
@yield('head')


<!-- CSS -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/lightbox.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">


<!-- scripts -->

<script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><!-- Uikit javascript-->
<script src="{{ asset('js/lightbox.js') }}"></script>
<script src="{{ asset('js/parallax.js') }}"></script>




<link rel="stylesheet" type="text/css" href="{{ URL::asset('/templates/coral-light/css/toggle-switches.css') }}">

@if(auth()->user()->lang == 'ar')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap/rtl/bootstrap-rtl.css') }}">
@endif
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<meta name="viewport" content="width=device-width, initial-scale= 1.0, user-scalable=0">
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=0disoxw0ri417kacpbbaufwzt6temhwubr87eejae2tyvpjy'></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/templates/coral-light/css/cpanel-styles.css') }}">

<script>
        tinymce.init({
        @yield('stylesheet')
          plugin: 'a_tinymce_plugin',
          plugins:'link image ',
          menubar: false,

        @if(auth()->user()->lang == 'ar')
			content_style: "div, p { text-align: right; font-family: 'Cairo', sans-serif; }",
		@endif


        });
</script>