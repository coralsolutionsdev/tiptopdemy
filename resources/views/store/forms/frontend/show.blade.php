@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <style>
    </style>
@endsection
@section('content')
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
        <div class="bg-secondary pt-25">
            <div class="uk-container">
                <div class="uk-margin uk-flex uk-flex-center" uk-grid>
                    <div class="uk-width-5-6" style="direction: {{$form->getDirection()}}">
                        <ul id="form-items" class="uk-grid-small" uk-grid>
                            @if($items = $form->getGroupedItems())
                                @forelse($items as $section => $items)
                                    @if(!is_null($displayType) && $displayType == 1)
                                        {{--Todo: --}}
                                    @foreach($items as $item)
                                        @if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
                                            <li class="form-item uk-width-1-1 uk-margin-remove pb-1">
                                                <div class="uk-grid-small uk-text-center" uk-grid>
                                                    <div class="uk-width-auto@m">
                                                        <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 10px">
                                                            <p class="uk-h4">{{$item->title}} ssssssssssssssss</p>
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
                                    @else
                                        <li class="form form-group uk-width-1-1@s bg-white uk-padding-small uk-grid-small" uk-grid style="margin: 3em 0px 0px 0px">
                                            @foreach($items as $key => $item)
                                            <div class="uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove" style="padding: 2px 0px">
                                                @if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
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
                                                    <div class="uk-grid-collapse" uk-grid>
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
                                                                    <label><input class="uk-radio" type="radio"> {{$option['title']}}</label>@if($item->properties['display'] == 1)<br>@endif
                                                                @endforeach
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_MULTI_CHOICE)
                                                                @if($item->properties['display'] == 1)<br>@endif
                                                                @foreach($item['options'] as $option)
                                                                    <label><input class="uk-checkbox" type="checkbox"> {{$option['title']}}</label>@if($item->properties['display'] == 1)<br>@endif
                                                                @endforeach
                                                            @elseif($item->type == \App\Modules\Form\FormItem::TYPE_DROP_DOWN)
                                                                @if($item->properties['display'] == 1)<br>@endif
                                                                    <select class="uk-select uk-form-small uk-form-width-small">
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
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        </li>
                                    @endif
                                @empty
                                    <div class="uk-placeholder uk-text-center bg-white uk-text-meta items-message">
                                        {{__('main.There is no form items yet.')}}.
                                    </div>
                                @endforelse
                            @endif
                        </ul>

                    </div>
                </div>
                <div class="uk-text-center" style="padding-bottom: 10px">
                    <span class="uk-button uk-button-primary uk-margin-small-right submit-form uk-width-1-3@l" >{{ucfirst($form->properties['submission_title'])}}</span>
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
    <script>
        $('.submit-form').click(function () {
            UIkit.modal('#please-purchase').show();
        });
    </script>

@endsection
