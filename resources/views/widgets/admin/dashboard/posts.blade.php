<div class="widget widget-warning uk-flex uk-flex-middle uk-box-shadow-hover-small" style="padding-top: 10px">
    <div class="uk-width-1-1">
        <div>
            <div class="icon-body">
                <i class="far fa-file-alt fa-2x uk-text-warning"></i>
            </div>
        </div>
        <div class="count-status"><span>{{$itemsCount}} {{__('main.posts')}}</span></div>
        <div class="uk-text-meta"><span>0 {{trans_choice('main.new post today', 0)}}</span></div>
        <div class="uk-text-meta pt-1"><a class="uk-button uk-button-small uk-button-default uk-widget-button" href="{{Route('posts.create')}}">{{__('main.add')}}</a>
        </div>
    </div>
</div>