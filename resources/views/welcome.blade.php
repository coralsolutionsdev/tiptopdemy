@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'Home')
@section('content')
    @if(!empty($layout))
        @foreach($layout->structure as $item)
            @if(!empty(getWidgetName($item)))
            @widget('home.'.getWidgetName($item),['items' => $item])
            @endif
        @endforeach
    @else
        <section>
            <div class="uk-container">
                <div class="uk-flex uk-flex-center uk-padding" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-2-3@m uk-padding">
                        <div class="uk-child-width-expand@s" uk-grid>
                            <div class="uk-flex uk-flex-middle uk-text-center">
                                <div class="uk-text-center">
                                    <img src="{{asset_image('/assets/true_friends.png')}}" width="300">
                                </div>
                            </div>
                            <div>
                                <div class="uk-flex-center uk-text-center" style="padding-top: 20px">
                                    <div>
                                        <h3 class="uk-card-title uk-text-primary">Welcome to {{getApplicationDomain()}}</h3>
                                        <p style="margin: 0px; padding: 0px; text-align: justify; text-justify: inter-word">
                                            {{getSite()->description}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection