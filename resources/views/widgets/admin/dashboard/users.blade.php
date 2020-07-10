<div class="widget widget-primary uk-flex uk-flex-middle uk-box-shadow-hover-small" style="padding-top: 10px">
    <div class="uk-width-1-1">
        <div>
            <a href="{{Route('users.index')}}">
                <div class="icon-body">
                    <i class="fas fa-users fa-2x uk-text-primary"></i>
                </div>
            </a>
        </div>
        <div class="count-status"><span>{{$itemsCount}} {{__('main.users')}}</span></div>
        <div class="uk-text-meta"><span>0 {{trans_choice('main.new user today', 0)}}</span></div>
        <div class="uk-text-meta pt-1"><a class="uk-button uk-button-small uk-button-default uk-widget-button" href="{{Route('users.index')}}">{{__('main.view')}}</a>
        </div>
    </div>
</div>
