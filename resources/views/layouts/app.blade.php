<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="/templates/coral-light/css/default-styles.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/templates/coral-light/css/default-styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/templates/coral/css/toggle-switches.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/awesome/css/font-awesome.css') }}">
    <!-- Direction -->
    @if(Auth()->user())
      @if(Auth()->user()->lang == 'ar')
      <link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap/rtl/bootstrap-rtl.css') }}">
      @endif
    @else
      @if(session('lang') == 'ar')
      <link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap/rtl/bootstrap-rtl.css') }}">
      @endif
    @endif
  </head>
  <body>
      @yield('content')
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </body>
</html>