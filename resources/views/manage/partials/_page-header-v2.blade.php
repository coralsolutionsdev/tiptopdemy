<div class="uk-grid-collapse" uk-grid style="margin-bottom: 10px">
    <div class="uk-width-auto">
        <p class="uk-text-bold uk-margin-remove" style="padding: 10px">{{!empty($modelName) ? __('main.'.$modelName) : __('main._home')}}</p>
        @if(!empty($breadcrumb))
            <div class="uk-flex">
                <span uk-icon="home" style="margin: 0 5px"></span>{!! $breadcrumb !!}
            </div>
        @endif
    </div>
    <div class="uk-width-expand">
    </div>
    <div class="uk-width-1-5 uk-flex uk-flex-middle uk-flex-right">
        @yield('page-header-button')
    </div>
</div>
