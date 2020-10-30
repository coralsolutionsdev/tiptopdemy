@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <style>
    </style>
@endsection
@section('content')
    <section>
        <div class="store uk-container uk-margin-medium-bottom">
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
                    <div class="quiz-section bg-secondary pt-25 {{$hasTimeLimit == 1 ? 'hidden-div' : ''}}">
                        <div class="uk-container">
                            {{--Form--}}
                            <div class="uk-margin" style="direction: {{$form->getDirection()}};">
                                {{--Form info--}}
                                <div class="uk-margin-medium">
                                    <span><label class="uk-text-danger"><input class="uk-checkbox uk-checkbox-danger uk-checkbox-rounded" type="checkbox" checked> {{__('main.Pass')}}</label></span>
                                    <br>
                                    <span><label class="uk-text-warning"><input class="uk-checkbox uk-checkbox-warning uk-checkbox-rounded" type="checkbox" checked> {{__('main.Review')}}</label></span>
                                </div>

                                {{--Form sections--}}
                                {!! Form::open(['url' => route('form.response.store', $form->hash_id),'method' => 'POST', 'id' => 'quiz-form', 'enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
                                <div class="uk-margin-medium-top" style="">
                                    <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                                    @if($formItems = $form->getGroupedItems())
                                        @php
                                            $sectionCount = 0;
                                        @endphp
                                        <ul class="uk-list">
                                            @php $firstSection = null; @endphp
                                            @forelse($formItems as $section => $items)
                                                @php
                                                    $sectionCount++;
                                                      if (empty($firstSection)){
                                                            $firstSection = $sectionCount;
                                                        }
                                                @endphp
                                                @if(!is_null($displayType) && $displayType == 1)
                                                    @include('store.forms.frontend.displays._modern')
                                                @else
                                                    @include('store.forms.frontend.displays._traditional')
                                                @endif
                                            @empty
                                                no Items message
                                            @endforelse
                                        </ul>
                                    @endif
                                </div>
                                {!! Form::close() !!}

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="please-purchase" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h1 class="uk-modal-title uk-text-warning">{{__('main.Oops')}} !!</h1>
            <p>{{__('main.To complete this step, please purchase the item first')}}.</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('main.Ok')}}</button>
            </p>
        </div>
    </div>
    <div id="quizHasTimeModal" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">{{__('main.Quiz period')}}</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <p>
                    {{__('main.Dear', ['name' => getAuthUser()->first_name])}}, {{__('main.this quiz have limited time to answer, which is')}} {{$timeLimit}} {{trans_choice('main.Minutes',$timeLimit)}} <br>
                    {{__('main.Are you sure that you want to start the quiz?')}}
                </p>
                <button class="uk-button uk-button-primary start-quiz">{{__('main.Yes, Start the quiz')}}</button>
            </div>
        </div>
    </div>
    <div id="quizEndedModal" uk-modal="bg-close: false">
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">{{__('main.Quiz time finished')}}</h2>
            </div>
            <div class="uk-modal-body uk-text-center">
                <p>
                    {{__('main.Dear', ['name' => getAuthUser()->first_name])}}, {{__('main.the time to end this quiz has been finished, we hope you done well with it')}}<br>
                </p>
                <a href="{{route('store.lesson.show', [$product->slug, $lesson->slug])}}" class="uk-button uk-button-primary start-quiz">{{__('main.back to the lesson')}}</a>
            </div>
        </div>
    </div>
    {{--Counter--}}
    <div class="quiz-countdown" style="padding: 10px; z-index: 99; position: fixed; bottom: 0; display: none">
        <div class="uk-text-center uk-text-primary" style="position: absolute; margin-top: -20px; width: 90%">
            <span uk-icon="icon: clock; ratio: 2"></span>
        </div>
        <div class="uk-box-shadow-small" style="padding:10px 20px; background-color: rgba(255, 255, 255, 0.9); border-radius: 5px">
            <div class="uk-grid-small uk-child-width-auto countdown" uk-grid>
                <div class="uk-text-center">
                    <h1 class="uk-margin-remove timer uk-heading-medium" id="time"><span style="font-size: 38px">{{__('main.Starting')}} ..</span></h1>
                </div>
            </div>
        </div>

    </div>
    @include('store.forms.frontend.scripts._show-script')
    <script>
        $('.submit-form').click(function () {
            UIkit.modal('#please-purchase').show();
        });
    </script>

@endsection
