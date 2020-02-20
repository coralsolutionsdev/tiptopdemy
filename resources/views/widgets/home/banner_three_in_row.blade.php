<section class="p_120">
    <div class="container">
        <div class="main_title">
            <h2>{{$title}}</h2>
            <p>{{$description}}</p>
        </div>
        <div class="row">
            @foreach($banners as $banner)
            <div class="col-lg-4 col-sm-6">
                <div class="projects_item">
                    <img class="img-fluid" src="{{asset_image($banner->image)}}" alt="" style="width: 100%;height: 340px;object-fit: cover;">
                    <div class="projects_text">
                        <a href="portfolio-details.html"><h4>{{$banner->title}}</h4></a>
                        <p>{!! subContent($banner->content,60) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
