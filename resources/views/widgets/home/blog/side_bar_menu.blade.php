{{-- Search --}}
<div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
{{--    <h3 class="uk-card-title">Secondary</h3>--}}
    <form action="{{ route('blog.posts.main') }}" method="GET" class="home-search">
        <fieldset class="uk-fieldset">
                <div class="uk-margin-small">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon uk-form-icon-flip uk-text-primary" uk-icon="icon: search"></span>
                        <input class="uk-input" name="search_key" type="text" placeholder="{{__('main.Search in Blog')}} .." value="{{!empty($search_key) ? $search_key : ''}}" required>
                    </div>
                </div>
        </fieldset>
        <button class="uk-button uk-button-primary uk-width-1-1">{{__('main.search')}}</button>
    </form>
</div>
{{-- Categories --}}
<div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
    <h5 class="text-highlighted" style="padding: 0px; font-weight: 700">{{__('main._categories')}}</h5>
    <div class="uk-margin-small">
        <ul class="uk-list uk-list-divider">
            @foreach($categories as $category)
                <li style="padding: 5px 5px 0px 5px"><span><a href="{{route('blog.category.show', $category->slug)}}">{{$category->name}}</a></span><span class="uk-align-{{getFloatKey('end')}}"><span class="uk-badge uk-badge-mini uk-badge-success">{{$category->items()->where('status', \App\BlogPost::STATUS_ENABLED)->count()}}</span></span></li>
            @endforeach
        </ul>
    </div>
</div>

@if(!empty($posts))
    <div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
        <h5 class="text-highlighted" style="padding: 0px; font-weight: 700">{{__('main._latest_posts')}}</h5>
        <div class="uk-margin-small">
            @foreach($posts as $post)
                <a style="padding: 0px; margin: 0px" href="{{route('blog.posts.show',$post->slug)}}">
                    <div class="uk-margin uk-grid-collapse" uk-grid>
                        <div class="uk-width-1-3@m uk-width-1-1 uk-card-media-right uk-cover-container">
                            <img src="{{$post->getMainImage()}}" style="width: 100%">
                        </div>
                        <div class="uk-width-2-3@m uk-width-1-1" style="padding: 0px 10px">
                            {{$post->title}}
                            <p style="padding: 0px; margin: 0px" class="uk-text-muted"> {{$post->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
{{-- Tags --}}
<div class="uk-margin-small" style="padding: 20px">
    <h5 class="text-highlighted" style="padding: 0px; font-weight: 700">{{__('main._tags')}}</h5>
    <div class="uk-margin-small">
        <div class="blog-tags">
            @foreach($tags as $tag)
                <a class="uk-button uk-button-default uk-background-default" href="#">{{$tag->name}}</a>
            @endforeach
        </div>
    </div>
</div>

