<div class="{{$items['container'] == 1 ? 'uk-container' : ''}}">
    @if(!empty($items['description']))
    <div>
        <span>{{$items['description']}}</span>
    </div>
    @endif
    <div class="uk-grid-collapse uk-child-width-1-1@s uk-child-width-1-{{$items['grid']}}@m" uk-grid style="padding: {{$items['grid_padding'] > 0 ? $items['grid_padding'] : 0}}px {{$items['grid_padding'] > 0 ? $items['grid_padding'] / 2 : 0}}px">
        @foreach($banners as $banner)
            <div class="uk-inline banner-item" style="padding: 0px {{$items['grid_padding'] > 0 ? $items['grid_padding'] / 2 : 0}}px {{$items['grid_padding'] > 0 ? $items['grid_padding'] : 0}}px">
                <img src="{{$banner->getImageUrl()}}" alt="" style="width: 100%">
                <div class="uk-overlay uk-light uk-position-center-{{$items['text_alignment']}}">
                    {!! $banner->content !!}
                </div>
            </div>
        @endforeach
    </div>
</div>
