<div class="uk-card uk-card-default uk-card-body" style="padding: 20px">
    {{--Search--}}
    <fieldset class="uk-fieldset">
        <div class="uk-margin">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip uk-text-primary" uk-icon="icon: search"></span>
                    <input class="uk-input" type="text" placeholder="Search in Blog ..">
                </div>
            </div>
        </div>
    </fieldset>
    <hr>
    {{-- Recent posts --}}
    <div class="" style="padding-bottom: 10px">
        <div class="uk-background-muted uk-text-center" style="border:1px solid var(--theme-primary-color)">
            <p class="uk-h4 uk-text-capitalize" style="padding: 8px">Latest posts</p>
        </div>
    </div>
    @foreach($posts as $post)
        <div class="recent-posts uk-card uk-card-default uk-grid-collapse" uk-grid>
            <div class="uk-card-media-left uk-cover-container uk-width-1-3@s">
                <img src="{{asset_image($post->image)}}" alt="">
                <canvas width="75" height="20"></canvas>
            </div>
            <div class="uk-width-2-3@s">
                <div class="uk-card-body" style="font-size: 10px">
                    <p>
                        <a href="{{route('blog.posts.show',$post->slug)}}">
                           {{$post->title}}
                        </a>
                    </p>
                    <p class="uk-text-muted"> {{$post->created_at->diffForHumans()}}</p>
                </div>
            </div>
        </div>
    @endforeach
    <hr>
    {{-- Categories --}}
    <div class="" style="padding-bottom: 10px">
        <div class="uk-background-muted uk-text-center" style="border:1px solid var(--theme-primary-color)">
            <p class="uk-h4 uk-text-capitalize" style="padding: 8px">Categories</p>
        </div>
    </div>
    <div>
        <ul class="uk-list uk-list-divider">

        </ul>
        <ul class="uk-list uk-list-divider">
            @foreach($categories as $category)
                <li style="padding: 5px 5px 0px 5px"><span><a href="">{{$category->name}}</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
{{--                <li><a href="{{route('blog.category.show',$category->slug)}}"></a> <span class="uk-align-right@m">{{ !empty($category->posts) ? $category->posts->count() : 0}}</span></li>--}}
            @endforeach
        </ul>
    </div>
    <hr>
    {{-- Tags --}}
    <div class="" style="padding-bottom: 10px">
        <div class="uk-background-muted uk-text-center" style="border:1px solid var(--theme-primary-color)">
            <p class="uk-h4 uk-text-capitalize" style="padding: 8px">Tags</p>
        </div>
    </div>
    <div class="blog-tags">
        <a class="uk-button uk-button-default" href="#">Tag</a>
        <a class="uk-button uk-button-default" href="#">Clearance</a>
        <a class="uk-button uk-button-default" href="#">Tag NAme</a>
        <a class="uk-button uk-button-default" href="#">Anonymous</a>
        <a class="uk-button uk-button-default" href="#">blog</a>

    </div>

</div>
