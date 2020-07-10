<div class="widget widget-success uk-flex uk-flex-middle uk-box-shadow-hover-small" style="padding-top: 10px">
    <div class="uk-width-1-1">
        <div>
            <div class="icon-body">
                <i class="fas fa-box-open fa-2x uk-text-success"></i>
            </div>
        </div>
        <div class="count-status"><span>{{$itemsCount}} {{__('main.Products')}}</span></div>
        <div class="uk-text-meta"><span>0 {{trans_choice('main.new product today', 0)}}</span></div>
        <div class="uk-text-meta pt-1"><a class="uk-button uk-button-small uk-button-default uk-widget-button" href="{{Route('store.products.create')}}">{{__('main.add')}}</a>
        </div>
    </div>
</div>
