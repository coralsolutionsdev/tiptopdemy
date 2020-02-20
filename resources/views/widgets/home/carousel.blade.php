<section>
    @if(false)
    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @php $carousel_count = 0; @endphp
            @foreach($carousels as $carousel)
                <li data-target="#carouselIndicators" data-slide-to="{{$carousel_count}}" class="{{ $carousel->id == $carousels->first()->id ? 'active' : '' }}"></li>
                @php $carousel_count++; @endphp
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($carousels as $carousel)
                <div class="carousel-item {{ $carousel->id == $carousels->first()->id ? 'active' : '' }}" style="">
                    <img class="d-block w-100" src="{{asset_image($carousel->image)}}" alt="First slide">
                    <div class="carousel-caption d-flex justify-content-center align-items-center" style="">
                        <div class="carousel-caption-body d-flex justify-content-{{$carousel->getAlignment()}}" style="">
                            <div class="carousel-caption-body-box text-left" style="">
                                <h1>{{$carousel->title}}</h1>
                                <p>{!! $carousel->content !!}</p>
                                <button class="btn banner_btn">Discover</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    @else
    <div uk-slideshow="animation: push">

        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

            <ul class="uk-slideshow-items">
                <li>
                    <img src="https://4.bp.blogspot.com/-87Yl9Yo58FY/W-mk9FS2qgI/AAAAAAAAAbs/IKmESyB2baUrFYLbWhRBcY5RQfj3QJHugCLcBGAs/s1600/Sunrise%2Bin%2BForest%2BMountains%2B4K%2BNature%2BBackground%2BStock%2BFootage.jpg" alt="" uk-cover>
                    <div class="uk-position-center uk-position-small uk-text-center">
                        <h2 uk-slideshow-parallax="x: 100,-100">Heading</h2>
                        <p uk-slideshow-parallax="x: 200,-200">Lorem ipsum dolor sit amet.</p>
                    </div>
                </li>
                <li>
                    <img src="https://4.bp.blogspot.com/-87Yl9Yo58FY/W-mk9FS2qgI/AAAAAAAAAbs/IKmESyB2baUrFYLbWhRBcY5RQfj3QJHugCLcBGAs/s1600/Sunrise%2Bin%2BForest%2BMountains%2B4K%2BNature%2BBackground%2BStock%2BFootage.jpg" alt="" uk-cover>
                    <div class="uk-position-center uk-position-small uk-text-center">
                        <h2 uk-slideshow-parallax="x: 100,-100">Heading</h2>
                        <p uk-slideshow-parallax="x: 200,-200">Lorem ipsum dolor sit amet.</p>
                    </div>
                </li>
                <li>
                    <img src="https://4.bp.blogspot.com/-87Yl9Yo58FY/W-mk9FS2qgI/AAAAAAAAAbs/IKmESyB2baUrFYLbWhRBcY5RQfj3QJHugCLcBGAs/s1600/Sunrise%2Bin%2BForest%2BMountains%2B4K%2BNature%2BBackground%2BStock%2BFootage.jpg" alt="" uk-cover>
                    <div class="uk-position-center uk-position-small uk-text-center">
                        <h2 uk-slideshow-parallax="y: -50,0,0; opacity: 1,1,0">Heading</h2>
                        <p uk-slideshow-parallax="y: 50,0,0; opacity: 1,1,0">Lorem ipsum dolor sit amet.</p>
                    </div>
                </li>
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

        </div>

{{--        <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>--}}

    </div>
    @endif
</section>