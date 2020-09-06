<div class="header uk-grid-collapse uk-padding-small uk-padding-remove-left uk-padding-remove-right" uk-grid>
    <div class="uk-width-expand">
        <p style="margin-bottom: -5px">{{__('main.Products browser')}}</p>
        <p class="text-highlighted" style="font-size: 26px; font-weight:700">{{__($page_title)}}</p>
    </div>
    <div class="uk-width-auto uk-flex uk-flex-bottom">
        <ul class="uk-breadcrumb">
            <li><span uk-icon="home"></span></li>
            @foreach($breadcrumb as $page => $link)
                <li><a href="">{{__($page)}}</a></li>
            @endforeach
        </ul>
    </div>
</div>