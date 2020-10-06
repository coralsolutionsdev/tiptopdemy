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
                                <div class="uk-margin-medium-top" style="">
                                    @if($formItems = $form->getGroupedItems())
                                        <ul class="uk-list">
                                            @forelse($formItems as $section => $items)
                                                @if(!is_null($displayType) && $displayType == 1)
                                                    this
                                                @else
                                                    @include('store.forms.frontend.displays._traditional')
                                                @endif
                                            @empty
                                                no Items message
                                            @endforelse
                                        </ul>

                                    @endif
                                </div>

                            </div>



                            <div class="uk-margin uk-flex uk-flex-center" uk-grid>
                                <div id="" class=" uk-width-5-6 " >

                                    {{--if dispalay type is traditional (0) --}}


                                    @if(false)
                                    <ul id="form-items" class="uk-grid-small" uk-grid style="">
                                        @if($formItems = $form->getGroupedItems())
                                            @forelse($formItems as $section => $items)
                                                @if(!is_null($displayType) && $displayType == 1)
                                                    {{--Todo: --}}
                                                    @if(!empty($items))
                                                        @foreach($items as $item)
                                                            @if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
                                                                <li class="form-item uk-width-1-1 uk-margin-remove pb-1">
                                                                    <div class="uk-grid-small uk-text-center" uk-grid>
                                                                        <div class="uk-width-auto@m">
                                                                            <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 10px">
                                                                                <p class="uk-h4">{{$item->title}} </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m uk-padding-small">
                                                                        <div>
                                                                            <h5 class="uk-card-title uk-text-primary"></h5>
                                                                            <p>
                                                                                {!! $item->description !!}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_SHORT_ANSWER)
                                                                <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove pb-1">
                                                                    <div class="uk-card uk-card-default uk-card-body">
                                                                        @include('store.forms.frontend._item_header')
                                                                        <div class="uk-margin-small">
                                                                            <input class="uk-input" type="text" placeholder="{{__('main.Your answer')}}">
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_PARAGRAPH)
                                                                <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove pb-1">
                                                                    <div class="uk-card uk-card-default uk-card-body">
                                                                        @include('store.forms.frontend._item_header')
                                                                        <div class="uk-margin-small">
                                                                            <textarea class="uk-textarea" rows="5" placeholder="{{__('main.Your answer')}}"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_SINGLE_CHOICE)
                                                                <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove pb-1">
                                                                    <div class="uk-card uk-card-default uk-card-body">
                                                                        @include('store.forms.frontend._item_header')
                                                                        <div class="uk-margin-small">
                                                                            <div class="uk-form-controls">
                                                                                @foreach($item['options'] as $option)
                                                                                    <div class="uk-margin-small"><label><input class="uk-radio" type="radio" name="radio1"> {{$option['title']}}</label></div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_MULTI_CHOICE)
                                                                <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove pb-1">
                                                                    <div class="uk-card uk-card-default uk-card-body">
                                                                        @include('store.forms.frontend._item_header')
                                                                        <div class="uk-margin-small">
                                                                            <div class="uk-form-controls">
                                                                                @foreach($item['options'] as $option)
                                                                                    <div class="uk-margin-small"><label><input class="uk-checkbox" type="checkbox"> {{$option['title']}}</label></div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_DROP_DOWN)
                                                                <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove pb-1">
                                                                    <div class="uk-card uk-card-default uk-card-body">
                                                                        @include('store.forms.frontend._item_header')
                                                                        <div class="uk-margin-small">
                                                                            <div class="uk-form-controls">
                                                                                <select class="uk-select">
                                                                                    @foreach($item['options'] as $option)
                                                                                        <option>{{$option['title']}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK)
                                                                <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove pb-1">
                                                                    <div class="uk-card uk-card-default uk-card-body">
                                                                        @include('store.forms.frontend._item_header')
                                                                        <div class="uk-margin-small">
                                                                            {!! $item->getFillableBlank() !!}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <li id="{{$section}}" class="form form-group uk-width-1-1@s bg-white uk-padding-small uk-grid-small" uk-grid style="margin: 3em 0px 0px 0px">
                                                        @if(!empty($items))
                                                            @foreach($items as $key => $item)
                                                                <div class="uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove" {!! $item->getToolTip() !!} style="padding: 2px 0px">
                                                                    @if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
                                                                        @php
                                                                            $questionsToAnswer = isset($item->properties['allowed_number']) ?  $item->properties['allowed_number'] : null;
                                                                        @endphp
                                                                        <div class="uk-grid-small uk-text-center" uk-grid style="position: absolute; margin-top: -48px;">
                                                                            <div class="uk-width-auto@m">
                                                                                <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 20px">
                                                                                    <p class="uk-h5">{{$item->title}}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="uk-grid-collapse" uk-grid>
                                                                            <div class="uk-width-expand@m" style="padding: 0 5px">
                                                                                {!! $item->description !!}
                                                                            </div>
                                                                            <div class="uk-width-auto@m uk-text-success">
                                                                                {{$item->score}} Marks
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="uk-grid-collapse question-row {{!empty($questionsToAnswer) && $questionsToAnswer < $key ? 'uk-background-danger-light' : ''}}" uk-grid>
                                                                            <div class="uk-width-auto@m">
                                                                                {{$key}}:
                                                                            </div>
                                                                            <div class="uk-width-expand@m question" style="padding: 0 5px">
                                                                                {!! $item->title !!}
                                                                                @if($item->type == \App\Modules\Form\FormItem::TYPE_SHORT_ANSWER)
                                                                                    @if($item->properties['display'] == 1)<br>@endif
                                                                                    <input class="input-classic" type="text" placeholder="{{__('main.Your answer')}}">
                                                                                @elseif($item->type == \App\Modules\Form\FormItem::TYPE_SINGLE_CHOICE)
                                                                                    @if($item->properties['display'] == 1)<br>@endif
                                                                                    @foreach($item['options'] as $option)
                                                                                        <label><input class="uk-radio" type="radio" name="radio-{{$item->id}}"> {{$option['title']}}</label>@if($item->properties['display'] == 1)<br>@endif
                                                                                    @endforeach
                                                                                @elseif($item->type == \App\Modules\Form\FormItem::TYPE_MULTI_CHOICE)
                                                                                    @if($item->properties['display'] == 1)<br>@endif
                                                                                    @foreach($item['options'] as $option)
                                                                                        <label><input class="uk-checkbox" type="checkbox"> {{$option['title']}}</label>@if($item->properties['display'] == 1)<br>@endif
                                                                                    @endforeach
                                                                                @elseif($item->type == \App\Modules\Form\FormItem::TYPE_DROP_DOWN)
                                                                                    @if($item->properties['display'] == 1)<br>@endif
                                                                                    <select class="uk-select uk-form-small uk-form-width-small" style="padding-left: 20px">
                                                                                        <option>{{$form->getDirection() == 'ltr' ? 'Choose answer' : __('main.choose answer')}}</option>
                                                                                        @foreach($item['options'] as $option)
                                                                                            <option>{{$option['title']}}</option>
                                                                                        @endforeach
                                                                                    </select>


                                                                                @elseif($item->type == \App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK)
                                                                                    {!! $item->getFillableBlank() !!}
                                                                                @endif
                                                                            </div>
                                                                            <div class="uk-width-auto@m uk-text-lighter">
                                                                                {{$item->score}} Marks
                                                                                <label class=""><input uk-tooltip="{{__('main.Pass')}}" class="uk-checkbox uk-checkbox-danger uk-checkbox-rounded pass-question" type="checkbox" name="section-drop" {{!empty($questionsToAnswer) && $questionsToAnswer < $key ? 'checked' : ''}}></label>
                                                                                <label><input uk-tooltip="{{__('main.Review')}}" class="uk-checkbox uk-checkbox-warning uk-checkbox-rounded review-question" type="checkbox"></label>

                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </li>
                                                @endif
                                            @empty
                                                <div class="uk-placeholder uk-text-center bg-white uk-text-meta items-message">
                                                    {{__('main.There is no form items yet.')}}.
                                                </div>
                                            @endforelse
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(false)
    <section>
        {{--Header--}}
        <div class="">
            <div class="uk-container" style="padding-bottom: 20px">
                <div class="product-header">
                    <div class="uk-grid-small" uk-height-match="target: > div > .uk-card; row: false" uk-grid>
                        <div class="nav-col" style="width: 5%">
                                <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#prev-form').submit()">
                                    <span uk-icon="icon: chevron-{{getFloatKey('end')}}"></span>
                                </div>
                            <form id="prev-form" method="GET" action="{{!empty($prevLesson) ? route('store.lesson.show', [$product->slug, $prevLesson->slug]) : route('store.lesson.show', [$product->slug, $lesson->slug])}}">
                            </form>
                        </div>
                        <div class="uk-width-expand@m">
                            <div class="uk-card uk-card-body uk-padding-small" style="background: linear-gradient(45deg,{{str_replace(['"', '[', ']'], '', json_encode($product->getColorPattern()->gradient))}}); color: #FFFFFF">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-4@m">
                                        <div class="uk-card uk-card-body uk-padding-small">
                                            <div class="thumbnail uk-border-circle" style="width: 200px; height: 200px; border: 7px solid rgba(255,255,255,0.4)">
                                                <img src="{{$product->getProductPrimaryImage()}}" class="portrait" alt="Image" width="200" height="200"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-expand@m uk-flex uk-flex-middle uk-text-{{getFloatKey('start')}}">
                                        <div class="uk-card uk-card-body uk-padding-small product-header-body">
                                            <h3 class="uk-text-bold" style="margin: 0px">{{$product->name}}</h3>
                                            <h4 class="uk-text-bold" style="margin: 0px">{{$lesson->title}}</h4>
                                            <p style="margin: 5px">{!! $product->description !!}</p>
                                            <p><strong>{{__('main.By')}}: </strong> {{$product->user->name}}</p>
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
                        <div class="nav-col" style="width: 5%">
                            <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#next-form').submit()">
                                <span uk-icon="icon: chevron-{{getFloatKey('start')}}"></span>
                            </div>
                            <form id="next-form" method="GET" action="{{!empty($nextLesson) ? route('store.lesson.show', [$product->slug, $nextLesson->slug]) : route('store.lesson.show', [$product->slug, $lesson->slug])}}">
                            </form>
                        </div>
                    </div>

                </div>
                <div style="padding-top: 20px ">
                    <ul class="breadcrumb">
                        <li>
                            <span uk-icon="home"></span>
                        </li>
                        @foreach($breadcrumb as $page => $link)
                            <li><a href="">{{__($page)}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{--Header end--}}
    </section>
    @endif
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
    @include('store.forms.frontend._show-script')
    <script>
        $('.submit-form').click(function () {
            UIkit.modal('#please-purchase').show();
        });
    </script>

@endsection
