<div class="header" style="padding: 3em 0 2em 0">
    <div class="uk-grid-collapse" uk-grid>
        <div class="uk-width-expand@m uk-width-1-1@s">
            <div>
                <p >{{!empty($modelName) ? __('main.'.$modelName) : __('main._home')}}</p>
                <p class="uk-margin-remove text-highlighted" style="font-size: 26px; font-weight:700">{{__($page_title)}}</p>
            </div>
        </div>
        @if(!empty($breadcrumb))
        <div class="uk-width-auto@m uk-width-1-1@s uk-flex uk-flex-bottom">
           <span uk-icon="home" style="margin: 0 5px"></span>{!! $breadcrumb !!}
        </div>
        @endif
    </div>
</div>
