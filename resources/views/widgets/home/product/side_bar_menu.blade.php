{{-- Categories --}}
<div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
    <h5 class="text-highlighted" style="padding: 0px; font-weight: 700">{{__('main._categories')}}</h5>
    <div class="uk-margin-small">
        <ul class="uk-list uk-list-divider">
            @foreach($categories as $category)
                <li style="padding: 5px 5px 0px 5px"><span><a href="{{route('store.category.show', $category->slug)}}">{{$category->name}}</a></span><span class="uk-align-left"><span class="uk-badge uk-badge-mini uk-badge-success">{{$category->getAvailableItems()->count()}}</span></span></li>
            @endforeach
        </ul>
    </div>
</div>
<div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
    <form action="{{ route('store.products.main') }}" method="GET" class="home-search">
        <h5 class="text-highlighted" style="padding: 0px; font-weight: 700">{{__('main.Price range')}}</h5>
        <div class="uk-margin-small uk-grid-small uk-child-width-1-2" uk-grid>
            <div class="input-group">
                <div class="item-title">
                    <span class="title">{{__('main.From')}}</span>
                </div>
                <input class="uk-input" name="min" type="text" placeholder="$" value="{{ $_GET['min'] ?? '' }}">
            </div>
            <div class="input-group">
                <div class="item-title">
                    <span class="title">{{__('main.To')}}</span>
                </div>
                <input class="uk-input" name="max" type="text" placeholder="$" value="{{ $_GET['max'] ?? '' }}">
            </div>
        </div>
        <div style="padding-top: 5px">
            <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">{{__('main.Filter prices')}}</button>
        </div>
    </form>

</div>
{{-- Tags --}}
<div class="uuk-margin-small" style="padding: 20px">
    <h5 class="text-highlighted" style="padding: 0px; font-weight: 700">{{__('main._tags')}}</h5>
    <div class="uk-margin-small">
        <div class="blog-tags">
            @foreach($tags as $tag)
                <a class="uk-button uk-button-default uk-background-default" href="#">{{$tag->name}}</a>
            @endforeach
        </div>
    </div>
</div>

