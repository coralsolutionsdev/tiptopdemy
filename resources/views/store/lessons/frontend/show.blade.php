@extends('themes.'.getFrontendThemeName().'.v2.layout')
@section('title', $page_title)
@section('head')
    <link rel="stylesheet" href="{{url('themes/general/modules/css/page_builder.css?v=202010241400')}}">
@endsection
@section('content')
<section >
    <div id="vue-app" class="store uk-container uk-margin-medium-bottom">
        {{--header--}}
        @include('partial.frontend._page-header')
        {{--body--}}
        <div class="uk-grid-small uk-child-width-1-1" uk-grid>
            <div>
                {{--Header--}}
                <div class="product-header uk-visible@m">
                    <div class="uk-grid-small" uk-height-match="target: > div > .uk-card; row: false" uk-grid>
                        <div class="nav-col" style="width: 5%" uk-tooltip="Previous">
                            <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#prev-form').submit()">
                                <span uk-icon="icon: chevron-{{getFloatKey('end')}}"></span>
                            </div>
                        </div>
                        <div class="uk-width-expand@m">
                            <div class="uk-card uk-card-body uk-padding-small" style="background: linear-gradient(45deg,{{str_replace(['"', '[', ']'], '', json_encode($product->getColorPattern()->gradient))}}); color: #FFFFFF">
                                <div class="uk-grid-small" uk-grid>
                                    @if(true)
                                    <div class="uk-width-auto@m uk-flex uk-flex-middle">
                                        <div class="uk-card uk-card-body uk-padding-remove">
                                            <img src="{{$product->getProductPrimaryImage()}}" alt="Paris" width="100" height="100" style="width:100px;  height:100px;  object-fit:cover; border: 7px solid rgba(255,255,255,0.4); border-radius: 5px">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="uk-width-expand@m uk-flex uk-flex-middle uk-text-{{getFloatKey('start')}}">
                                        <div class="uk-card uk-card-body uk-padding-remove product-header-body">
                                            <h4 class="uk-margin-remove uk-text-bold">{{$product->name}}</h4>
                                            <h5 class="uk-margin-remove uk-text-bold uk-light">{{$lesson->title}}</h5>
                                            <p class="uk-margin-small"><span><img class="uk-border-circle" src="{{$product->user->getProfilePicURL()}}" style="width: 20px; height: 20px; object-fit: cover"></span> <span>{{__('main.By')}}: </span> <span> {{$product->user->name}}</span></p>
                                            <div class="product-tags">
                                                @foreach($product->tagsWithType('product') as $tag)
                                                    <a class="uk-button uk-button-default" href="#">{{$tag->name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-4@m">
                                        <div class="uk-card uk-card-body uk-flex uk-flex-middle uk-padding-small uk-height-1-1" style="background-color: rgba(0,0,0,0.09)">
                                            <ul class="uk-list">
                                                <li><span uk-icon="icon: play-circle"></span> {{$product->lessons->count()}} {{__('main.lessons')}}</li>
                                                <li><span uk-icon="icon: file-text"></span> {{$product->groups->count()}} {{__('main.units')}}</li>
                                                <li><span uk-icon="icon: file-edit"></span> {{$product->lessons->where('type', \App\Modules\Course\Lesson::TYPE_QUIZ)->count()}} {{__('main.quizzes')}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-col" style="width: 5%" uk-tooltip="Next">
                            <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#next-form').submit()">
                                <span uk-icon="icon: chevron-{{getFloatKey('start')}}"></span>
                            </div>
                            <form id="next-form" method="GET" action="{{!empty($nextLesson) ? route('store.lesson.show', [$product->slug, $nextLesson->slug]) : route('store.lesson.show', [$product->slug, $lesson->slug])}}">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div>
                <lesson-show lesson-slug="{{$lesson->slug}}"></lesson-show>
            </div>
        </div>
    </div>

</section>
@include('partial.frontend._full_loading')
@endsection
