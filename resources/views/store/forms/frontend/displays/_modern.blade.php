<li id="section-{{$sectionCount}}" class="section {{$sectionCount != $firstSection ? 'hidden-div' : ''}} uk-width-1-1@s">
    <div id class="uk-grid-small uk-child-width-1-1" uk-grid>
        <div class="form-group"> {{--section items--}}
            <div class="" style="border-radius: 5px">
                @if(!empty($items))
                    @php
                    $key = 0;
                    @endphp
                    @if(!empty(\App\Modules\Form\FormItem::getGroupSection($items)))
                        @if(\App\Modules\Form\FormItem::getGroupSection($items)->title)
                            <div class="uk-grid-small uk-text-center" uk-grid style="margin: 0 15px">
                                <div class="uk-width-auto@m">
                                    <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 20px">
                                        <p class="uk-h5">{{\App\Modules\Form\FormItem::getGroupSection($items)->title}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-grid-collapse" uk-grid>
                            <div class="uk-width-expand@m" style="padding: 0 5px">
                                {!! \App\Modules\Form\FormItem::getGroupSection($items)->description !!}
                            </div>
                            <div class="uk-width-auto@m uk-text-success">
                                {{\App\Modules\Form\FormItem::getGroupSection($items)->score}} Marks
                            </div>
                        </div>
                    @endif

                    @foreach(\App\Modules\Form\FormItem::getItemsWithShuffleStatus($items) as $item)
                        <div class="uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove" {!! $item->getToolTip() !!} style="padding: 2px 0px">
                            <input type="hidden" class="" name="item_id[]" value="{{$item->id}}">
                            @if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
                                @php
                                    $questionsToAnswer = isset($item->properties['allowed_number']) ?  $item->properties['allowed_number'] : null;
                                @endphp
                                <input type="hidden" class="section-{{$section}}-allowed-number" value="{{isset($item->properties['allowed_number']) ?  $item->properties['allowed_number'] : 0}}">
                            @else
                                @php $key++ @endphp


                                <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-grid-collapse question-row {{!empty($questionsToAnswer) && $questionsToAnswer < $key ? 'uk-background-danger-light' : ''}}" uk-grid style="margin: 3px 0">
                                    <div class="uk-width-auto@m">
                                        {{$key}}:
                                        <input type="hidden" class="section-{{$section}}-item" value="">
                                    </div>
                                    <div class="uk-width-expand@m question" style="padding: 0 5px">
                                        {!! $item->title !!}
                                        @if($item->type == \App\Modules\Form\FormItem::TYPE_SHORT_ANSWER)
                                            @if($item->properties['display'] == 1)<br>@endif
                                            <input class="input-classic" name="item_answer[{{$item->id}}]" type="text" placeholder="{{__('main.Your answer')}}">
                                        @elseif($item->type == \App\Modules\Form\FormItem::TYPE_PARAGRAPH)
                                            <textarea class="uk-textarea" name="item_answer[{{$item->id}}]" rows="5" placeholder="..." style="background-color: transparent"></textarea>
                                        @elseif($item->type == \App\Modules\Form\FormItem::TYPE_SINGLE_CHOICE)
                                            @if($item->properties['display'] == 1)<br>@endif
                                            @foreach($item['options'] as $option)
                                                <label><input class="uk-radio" type="radio" name="item_answer[{{$item->id}}]" value="{{$option['title']}}"> {{$option['title']}}</label>@if($item->properties['display'] == 1)<br>@endif
                                            @endforeach
                                        @elseif($item->type == \App\Modules\Form\FormItem::TYPE_MULTI_CHOICE)
                                            @if($item->properties['display'] == 1)<br>@endif
                                            @foreach($item['options'] as $option)
                                                <label><input class="uk-checkbox" name="item_answer[{{$item->id}}][]" value="{{$option['title']}}" type="checkbox"> {{$option['title']}}</label>@if($item->properties['display'] == 1)<br>@endif
                                            @endforeach
                                        @elseif($item->type == \App\Modules\Form\FormItem::TYPE_DROP_DOWN)
                                            @if($item->properties['display'] == 1)<br>@endif
                                            <select class="uk-select uk-form-small uk-form-width-small" name="item_answer[{{$item->id}}]" style="padding-left: 20px">
                                                <option value="">{{$form->getDirection() == 'ltr' ? 'Choose answer' : __('main.choose answer')}}</option>
                                                @foreach($item['options'] as $option)
                                                    <option value="{{$option['title']}}">{{$option['title']}}</option>
                                                @endforeach
                                            </select>
                                        @elseif($item->type == \App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK)
                                            {!! $item->getFillableBlank($item->id) !!}
                                        @endif
                                    </div>
                                    <div class="uk-width-auto@m uk-text-lighter">
                                        {{$item->score}} Marks
                                        <label><input uk-tooltip="{{__('main.Pass')}}" class="uk-checkbox uk-checkbox-danger uk-checkbox-rounded leave-question leave-question-{{$section}}" type="checkbox" name="item_leave[{{$item->id}}]" value="{{$item->id}}" {{!empty($questionsToAnswer) && $questionsToAnswer < $key ? 'checked' : ''}}></label>
                                        <label><input uk-tooltip="{{__('main.Review')}}" class="uk-checkbox uk-checkbox-warning uk-checkbox-rounded review-question" type="checkbox"></label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="form-group uk-margin-small"> {{--section navication--}}
            <div class="uk-grid-small uk-text-center" uk-grid>
                <div class="uk-width-auto">
                    @if($sectionCount != $firstSection)
                    <span class="uk-button uk-button-secondary section-navigation prev-section" data-value="0">{{__('main.Previous')}}</span>
                    @endif
                </div>
                <div class="uk-width-expand">
                </div>
                <div class="uk-width-auto">
                    @if($sectionCount < $formItems->count())
                    <span class="uk-button uk-button-secondary section-navigation next-section" data-value="1">{{__('main.Next')}}</span>
                    @elseif($product->hasPurchased())
                    <span class="uk-button uk-button-primary section-navigation" data-value="3">{{ucfirst($form->properties['submission_title'])}}</span>
                    @else
                        <div class="uk-alert-warning" uk-alert>
                            <p>{{__('main.Please, purchase the lesson to complete')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</li>
