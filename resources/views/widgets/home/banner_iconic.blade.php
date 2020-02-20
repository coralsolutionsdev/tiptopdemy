<section class="feature_area p_120">
    <div class="container">
        <div class="main_title">
            <h2>{{$title}}</h2>
            <p>{{$description}}</p>
        </div>
        <div class="feature_inner row">
            @foreach($iconic_banners as $iconic_banner)
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="{{$iconic_banner->icon}} text-center"></i>
                    <h4>{{$iconic_banner->title}}</h4>
                    <p>{!! subContent($iconic_banner->content,120) !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
