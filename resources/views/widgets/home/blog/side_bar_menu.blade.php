{{-- Search --}}
<div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 40px 20px">
{{--    <h3 class="uk-card-title">Secondary</h3>--}}
    <fieldset class="uk-fieldset">
            <div class="uk-margin-small">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip uk-text-primary" uk-icon="icon: search"></span>
                    <input class="uk-input" type="text" placeholder="Search in Blog ..">
                </div>
            </div>
    </fieldset>
    <button class="uk-button uk-button-primary uk-width-1-1">search</button>
</div>
{{-- LAtest posts --}}
<div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 20px">
    <h3 class="uk-card-title" style="padding: 0px">{{__('latest posts')}}</h3>
    <hr>
    <div class="uk-margin-small">
        @foreach($posts as $post)
            <div class="uk-child-width-1-2@s uk-margin" uk-grid>
                <div class="uk-card-media-right uk-cover-container">
                    <img src="{{asset_image($post->image)}}">
                </div>
                <div style="padding: 0px 5px">
                    <a style="padding: 0px; margin: 0px" href="{{route('blog.posts.show',$post->slug)}}">{{$post->title}}</a>
                    <p style="padding: 0px; margin: 0px" class="uk-text-muted"> {{$post->created_at->diffForHumans()}}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
{{-- Categories --}}
<div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 20px">
    <h3 class="uk-card-title" style="padding: 0px">{{__('categories')}}</h3>
        <hr>
    <div class="uk-margin-small">
        <ul class="uk-list uk-list-divider">
            @foreach($categories as $category)
                <li style="padding: 5px 5px 0px 5px"><span><a href="{{route('blog.category.show', $category->slug)}}">{{$category->name}}</a></span><span class="uk-align-left"><span class="uk-badge">{{$category->items()->count()}}</span></span></li>
            @endforeach
        </ul>
    </div>
</div>
{{-- Tags --}}
<div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 20px">
    <h3 class="uk-card-title" style="padding: 0px">{{__('Tags')}}</h3>
    <hr>
    <div class="uk-margin-small">
        <div class="blog-tags">
            @foreach($tags as $tag)
                <a class="uk-button uk-button-default uk-background-default" href="#">{{$tag->name}}</a>
            @endforeach
        </div>
    </div>
</div>

