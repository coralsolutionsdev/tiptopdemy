<div class="header" style="padding: 3em 0 2em 0">
    <div class="uk-grid-collapse" uk-grid>
        <div class="uk-width-1-1@s">
            <div>
                <p class="uk-text-bold">{{!empty($modelName) ? __('main.'.$modelName) : __('main._home')}}</p>
            </div>
        </div>
        @if(!empty($breadcrumb))
            <div class="uk-width-1-1@s uk-flex uk-flex-bottom" style="padding-top: 5px">
               <span uk-icon="home" style="margin: 0 5px"></span>{!! $breadcrumb !!}
            </div>
        @endif
    </div>
</div>
