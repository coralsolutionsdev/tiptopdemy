<li id="section-{{$section}}" class="section {{$section != 1 ? 'hidden-div' : ''}} uk-width-1-1@s">
    <div id class="uk-grid-small uk-child-width-1-1" uk-grid>
        @if(true)
        <div class="form-group"> {{--section items--}}
            <div class="bg-white uk-padding-small">
                @if(!empty($items))
                    @foreach($items as $key => $item)
                        <div class="uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove" {!! $item->getToolTip() !!} style="padding: 2px 0px">
                            @if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
                                @php
                                    $questionsToAnswer = isset($item->properties['allowed_number']) ?  $item->properties['allowed_number'] : null;
                                @endphp
                                <input type="hidden" class="section-{{$section}}-allowed-number" value="{{isset($item->properties['allowed_number']) ?  $item->properties['allowed_number'] : 0}}">
                                @if($item->title)
                                    <div class="uk-grid-small uk-text-center" uk-grid style="position: absolute; margin-top: -48px;">
                                        <div class="uk-width-auto@m">
                                            <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 20px">
                                                <p class="uk-h5">{{$item->title}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                        <input type="hidden" class="section-{{$section}}-item" value="">
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
                                        <label><input uk-tooltip="{{__('main.Pass')}}" class="uk-checkbox uk-checkbox-danger uk-checkbox-rounded pass-question pass-question-{{$section}}" type="checkbox" name="section-drop" {{!empty($questionsToAnswer) && $questionsToAnswer < $key ? 'checked' : ''}}></label>
                                        <label><input uk-tooltip="{{__('main.Review')}}" class="uk-checkbox uk-checkbox-warning uk-checkbox-rounded review-question" type="checkbox"></label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif
        <div class="form-group uk-margin-small"> {{--section navication--}}
            <div class="uk-grid-small uk-text-center" uk-grid>
                <div class="uk-width-auto">
                    @if($section != 1)
                    <span class="uk-button uk-button-secondary section-navigation prev-section" data-value="0">{{__('main.Previous')}}</span>
                    @endif
                </div>
                <div class="uk-width-expand">
                </div>
                <div class="uk-width-auto">
                    @if($section < $formItems->count())
                    <span class="uk-button uk-button-secondary section-navigation next-section" data-value="1">{{__('main.Next')}}</span>
                    @else
                    <span class="uk-button uk-button-primary submit-form" >{{ucfirst($form->properties['submission_title'])}}</span>

                    @endif
                </div>
            </div>
        </div>
    </div>
</li>

