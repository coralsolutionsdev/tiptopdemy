@extends('themes.'.getSite()->theme.'.layout')
@section('content')
@if(!empty($layout))
    @foreach($layout->structure as $item)
        @widget('home.'.$item['group'],['item' => $item])
    @endforeach
@else
    <section>
        <div class="d-flex align-items-center justify-content-center" style="min-height: 600px">
            <p class="display-2">Welcome to {{getSite()->name}}</p>
        </div>
    </section>
@endif
<!--================Home Banner Area =================-->
@if(false)
<section class="home_banner_area">
    <div class="banner_inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="home_left_img">
                        <img src="/themes/ronin/img/banner/home-left-1.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner_content">
                        <h5>This is me</h5>
                        <h2>Travor James</h2>
                        <p>You will begin to realise why this exercise is called the Dickens Pattern (with reference to the ghost showing Scrooge some different futures)</p>
                        <a class="banner_btn" href="#">Discover Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!--================End Home Banner Area =================-->

<!--================Carousel Area =================-->
{{--@widget('home.carousel')--}}
{{--<!--================End of Carousel Area =================-->--}}
{{--@widget('home.banner_three_in_row')--}}
{{--@widget('home.banner_iconic')--}}
{{--@widget('home.blog_posts')--}}

<!--================Welcome Area =================-->
@if(false)
<section class="welcome_area p_120">
    <div class="container">
        <div class="row welcome_inner">
            <div class="col-lg-6">
                <div class="welcome_text">
                    <h4>About Myself</h4>
                    <p>inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach. inappropriate behavior is often laughed.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="wel_item">
                                <i class="lnr lnr-database"></i>
                                <h4>$2.5M</h4>
                                <p>Total Donation</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="wel_item">
                                <i class="lnr lnr-book"></i>
                                <h4>1465</h4>
                                <p>Total Projects</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="wel_item">
                                <i class="lnr lnr-users"></i>
                                <h4>3965</h4>
                                <p>Total Volunteers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tools_expert">
                    <h3>Tools Expertness</h3>
                    <div class="skill_main">
                        <div class="skill_item">
                            <h4>After Effects <span class="counter">85</span>%</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill_item">
                            <h4>Photoshop <span class="counter">90</span>%</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill_item">
                            <h4>Illustrator <span class="counter">70</span>%</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill_item">
                            <h4>Sublime <span class="counter">95</span>%</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill_item">
                            <h4>Sketch <span class="counter">75</span>%</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Welcome Area =================-->

<!--================Feature Area =================-->
<section class="feature_area p_120">
    <div class="container">
        <div class="main_title">
            <h2>offerings to my clients</h2>
            <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $.17 each.</p>
        </div>
        <div class="feature_inner row">
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="flaticon-city"></i>
                    <h4>Architecture</h4>
                    <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $17 each.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="flaticon-skyline text-center"></i>
                    <h4>Interior Design</h4>
                    <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $17 each.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="flaticon-sketch text-center"></i>
                    <h4>Concept Design</h4>
                    <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $17 each.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="flaticon-city"></i>
                    <h4>Architecture</h4>
                    <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $17 each.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="flaticon-skyline"></i>
                    <h4>Interior Design</h4>
                    <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $17 each.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="flaticon-sketch"></i>
                    <h4>Concept Design</h4>
                    <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $17 each.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Feature Area =================-->

<!--================Projects Area =================-->
<section class="projects_area p_120">
    <div class="container">
        <div class="main_title">
            <h2>Our Recent Completed Projects</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
        </div>
        <div class="projects_fillter">
            <ul class="filter list">
                <li class="active" data-filter="*"><a href="#">All Categories</a></li>
                <li data-filter=".brand"><a href="#">Branding</a></li>
                <li data-filter=".work"><a href="#">Creative Work </a></li>
                <li data-filter=".web"><a href="#">Web Design</a></li>
            </ul>
        </div>
        <div class="projects_inner row">
            <div class="col-lg-4 col-sm-6 brand web">
                <div class="projects_item">
                    <img class="img-fluid" src="/themes/ronin/img/projects/projects-1.jpg" alt="">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>3D Helmet Design</h4></a>
                        <p>Client Project</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 brand work">
                <div class="projects_item">
                    <img class="img-fluid" src="/themes/ronin/img/projects/projects-2.jpg" alt="">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>3D Helmet Design</h4></a>
                        <p>Client Project</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 work">
                <div class="projects_item">
                    <img class="img-fluid" src="/themes/ronin/img/projects/projects-3.jpg" alt="">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>3D Helmet Design</h4></a>
                        <p>Client Project</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 brand web">
                <div class="projects_item">
                    <img class="img-fluid" src="/themes/ronin/img/projects/projects-4.jpg" alt="">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>3D Helmet Design</h4></a>
                        <p>Client Project</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 brand work">
                <div class="projects_item">
                    <img class="img-fluid" src="/themes/ronin/img/projects/projects-5.jpg" alt="">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>3D Helmet Design</h4></a>
                        <p>Client Project</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 brand work web">
                <div class="projects_item">
                    <img class="img-fluid" src="/themes/ronin/img/projects/projects-6.jpg" alt="">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>3D Helmet Design</h4></a>
                        <p>Client Project</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Projects Area =================-->

<!--================Testimonials Area =================-->
<section class="testimonials_area p_120">
    <div class="container">
        <div class="main_title">
            <h2>Testimonials</h2>
            <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $.17 each.</p>
        </div>
        <div class="testi_inner">
            <div class="testi_slider owl-carousel">
                <div class="item">
                    <div class="testi_item">
                        <p>As conscious traveling Paup ers we must always be oncerned about our dear Mother Earth. If you think about it, you travel across her face</p>
                        <h4>Fanny Spencer</h4>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
                <div class="item">
                    <div class="testi_item">
                        <p>As conscious traveling Paup ers we must always be oncerned about our dear Mother Earth. If you think about it, you travel across her face</p>
                        <h4>Fanny Spencer</h4>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
                <div class="item">
                    <div class="testi_item">
                        <p>As conscious traveling Paup ers we must always be oncerned about our dear Mother Earth. If you think about it, you travel across her face</p>
                        <h4>Fanny Spencer</h4>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Testimonials Area =================-->

<!--================Latest Blog Area =================-->
<section class="latest_blog_area p_120">
    <div class="container">
        <div class="main_title">
            <h2>Latest Posts from Blog</h2>
            <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price. You may see some for as low as $.17 each.</p>
        </div>
        <div class="row latest_blog_inner">
            {{--@foreach($posts as $post)--}}
            {{--<div class="col-lg-4">--}}
                {{--<div class="l_blog_item">--}}
                    {{--<div class="l_blog_img">--}}
                        {{--<img class="img-fluid" src="{{asset_image($post->image)}}" alt="">--}}
                    {{--</div>--}}
                    {{--<div class="l_blog_text">--}}
                        {{--<div class="date">--}}
                            {{--<a href="#">{{date_html($post->created_at)}}  |  By {{$post->user->name}}</a>--}}
                        {{--</div>--}}
                        {{--<a href="#"><h4>{{$post->title}}</h4></a>--}}
                        {{--<p>{{subContent($post->content,200)}}</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}

        </div>
    </div>
</section>
<!--================End Latest Blog Area =================-->
@endif

@endsection