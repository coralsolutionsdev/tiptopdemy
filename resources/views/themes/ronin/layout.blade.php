<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=0">

    <link rel="icon" href="/themes/ronin/img/favicon.png" type="image/png">
    <title>{{getSite()->name}}</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="/themes/ronin/css/bootstrap.css">
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
    <link rel="stylesheet" href="/themes/ronin/vendors/linericon/style.css">
    <link rel="stylesheet" href="/themes/ronin/vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/themes/ronin/vendors/lightbox/simpleLightbox.css">
    <link rel="stylesheet" href="/themes/ronin/vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="/themes/ronin/vendors/animate-css/animate.css">
    <link rel="stylesheet" href="/themes/ronin/vendors/flaticon/flaticon.css">
    <!-- main css -->
    <link rel="stylesheet" href="/themes/ronin/css/style.css">
    <link rel="stylesheet" href="/themes/ronin/css/responsive.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Markazi+Text" rel="stylesheet">
    <link rel="stylesheet" href="/themes/ronin/css/fonts.css">
    <link rel="stylesheet" href="/themes/ronin/css/blog.css">
    <link rel="stylesheet" href="/themes/ronin/css/general.css">
    <link rel="stylesheet" href="/themes/general/css/widgets.css">
    @yield('head')
    <script src="/js/jquery-sortable.js"></script>

</head>
<body>

<!--================Header Menu Area =================-->
<header class="header_area">
    <div class="main_menu" id="mainNav">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container box_1620">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.html"><img src="/themes/ronin/img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about-us.html">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.html">Services</a>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                                <li class="nav-item"><a class="nav-link" href="portfolio-details.html">Project Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="elements.html">Elements</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<!--================Header Menu Area =================-->
@yield('content')
<!--================Footer Area =================-->
<footer class="footer_area p_120">
    <div class="container">
        <div class="row footer_inner">
            <div class="col-lg-5 col-sm-6">
                <aside class="f_widget ab_widget">
                    <div class="f_title">
                        <h3>About Me</h3>
                    </div>
                    <p>Do you want to be even more successful? Learn to love learning and growth. The more effort you put into improving your skills,</p>
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </aside>
            </div>
            <div class="col-lg-5 col-sm-6">
                <aside class="f_widget news_widget">
                    <div class="f_title">
                        <h3>Newsletter</h3>
                    </div>
                    <p>Stay updated with our latest trends</p>
                    <div id="mc_embed_signup">
                        <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative">
                            <div class="input-group d-flex flex-row">
                                <input name="EMAIL" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                                <button class="btn sub-btn"><span class="lnr lnr-arrow-right"></span></button>
                            </div>
                            <div class="mt-10 info"></div>
                        </form>
                    </div>
                </aside>
            </div>
            <div class="col-lg-2">
                <aside class="f_widget social_widget">
                    <div class="f_title">
                        <h3>Follow Me</h3>
                    </div>
                    <p>Let us be social</p>
                    <ul class="list">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</footer>
<!--================End Footer Area =================-->





<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/themes/ronin/js/jquery-3.2.1.min.js"></script>
<script src="/themes/ronin/js/popper.js"></script>
<script src="/themes/ronin/js/bootstrap.min.js"></script>
<script src="/themes/ronin/js/stellar.js"></script>
<script src="/themes/ronin/vendors/lightbox/simpleLightbox.min.js"></script>
<script src="/themes/ronin/vendors/nice-select/js/jquery.nice-select.min.js"></script>
<script src="/themes/ronin/vendors/isotope/imagesloaded.pkgd.min.js"></script>
<script src="/themes/ronin/vendors/isotope/isotope-min.js"></script>
<script src="/themes/ronin/vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="/themes/ronin/js/jquery.ajaxchimp.min.js"></script>
<script src="/themes/ronin/vendors/counter-up/jquery.waypoints.min.js"></script>
<script src="/themes/ronin/vendors/counter-up/jquery.counterup.min.js"></script>
<script src="/themes/ronin/js/mail-script.js"></script>
<!--gmaps Js-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="/themes/ronin/js/gmaps.min.js"></script>
<script src="/themes/ronin/js/theme.js"></script>
@Include('layouts.partials._footer_scripts')

</body>
</html>