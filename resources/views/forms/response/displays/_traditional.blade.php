<li class="section uk-width-1-1@s uk-margin-medium-bottom">
    <div id class="uk-grid-small uk-child-width-1-1" uk-grid>
        <div class="form-group"> {{--section items--}}
            <div class="bg-white uk-padding-small uk-box-shadow-small" style="border-radius: 5px">
                @if(!empty($sectionItems))
                    @php
                    $key = 0;
                    @endphp
                    @foreach($sectionItems as $item)
                        <div id="{{$item['id']}}" class="quiz-item uk-width-{{$item['properties']['width']}}@m uk-width-1-1@s uk-margin-remove" style="padding: 2px 0px">
                            @if($item['type'] == \App\Modules\Form\FormItem::TYPE_SECTION)
                                @if(!empty($item['title']))
                                <div class="uk-grid-small uk-text-center" uk-grid style="position: absolute; margin-top: -49px;">
                                    <div class="uk-width-auto@m">

                                        <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 20px">
                                            <p class="uk-h5">{{$item['title']}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="uk-grid-collapse" uk-grid>
                                    <div class="uk-width-expand@m" style="padding: 0 5px">
                                        {!! $item['description'] !!}
                                    </div>
                                    <div class="uk-width-auto@m uk-text-success">
                                        {{$item['score']}} {{trans_choice('main.Marks', $item['score'])}}
                                    </div>
                                </div>
                            @else
                                @php $key++ @endphp
                                <div class="uk-grid-collapse question-row" uk-grid>
                                    <div class="uk-width-auto@m">
                                        {{$key}}:
                                    </div>
                                    <div class="uk-width-expand@m question" style="padding: 0 5px">
                                        @if($item['type'] == \App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK)
                                            <div class="item-fill-the-blank-paragraph">
                                                @if(!empty($item['answers']))
                                                    @foreach($item['answers'] as $answerKey => $answer)
                                                        <input type="hidden" class="item-{{$item['id']}}-answer-{{$answerKey}}-value" value="{{$answer['value']}}">
                                                        <input type="hidden" class="item-{{$item['id']}}-answer-{{$answerKey}}-score" value="{{$answer['score']}}">
                                                        <input type="hidden" class="item-{{$item['id']}}-answer-{{$answerKey}}-status" value="{{$answer['status']}}">
                                                    @endforeach
                                                @endif
                                                {!! \App\Modules\Form\FormItem::getFormItemFillableBlank($item['id']) !!}
                                            </div>
                                        @else
                                        {!! $item['title']!!}
                                        @if($item['properties']['display'] == 1)<br>@endif
                                        @if(!empty($item['answers']))
                                            @forelse($item['answers'] as $answer)
                                                <span uk-tooltip="{{$answer['score']}} {{trans_choice('main.Marks', $answer['score'])}}" class="uk-text-{{$answer['status'] == \App\Modules\Form\FormResponse::EVALUATION_STATUS_CORRECT ? 'success' : 'danger' }}">{{$answer['value']}} </span> <i class="far {{$answer['status'] == \App\Modules\Form\FormResponse::EVALUATION_STATUS_CORRECT ? 'fa-check-circle uk-text-success' : 'fa-times-circle uk-text-danger' }}"></i> @if($item['properties']['display'] == 1)<br>@endif
                                            @endforelse
                                        @endif
                                    </div>
                                    <div class="uk-width-auto@m">
                                       <span class="uk-text-success"> {{$item['evaluation_score']}}</span> / {{$item['score']}} <span class="uk-text-lighter">{{trans_choice('main.Marks', $item['evaluation_score'])}}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</li>

