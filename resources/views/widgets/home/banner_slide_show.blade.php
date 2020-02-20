<div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slideshow="animation: fade; autoplay: true; autoplay-interval: 4000" style="max-height: 700px">

    <ul class="uk-slideshow-items" style="max-height: 700px">
        @foreach($banners as $banner)
        <li class="" style="max-height: 700px">
            <img src="{{$banner->getImageUrl()}}" alt="" uk-cover>
            <div class="uk-position-center uk-position-small uk-text-center banner-item" style="width: 80%">
                <div uk-slideshow-parallax="x: 100,-100" class="">
                    {!! $banner->content !!}
                </div>
                <div class="uk-text-left" style="padding: 40px 0px">
                    <a class="uk-button uk-button-primary" href="">Read more</a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>

    <div class="uk-light">
        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
    </div>

</div>