{{-- Search --}}
<div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 40px 20px">
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
<div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 20px">
    <h3 class="uk-card-title" style="padding: 0px">{{__('main._categories')}}</h3>
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
    <h3 class="uk-card-title" style="padding: 0px">{{__('main._tags')}}</h3>
    <hr>
    <div class="uk-margin-small">
        <div class="blog-tags">
            @foreach($tags as $tag)
                <a class="uk-button uk-button-default uk-background-default" href="#">{{$tag->name}}</a>
            @endforeach
        </div>
    </div>
</div>

