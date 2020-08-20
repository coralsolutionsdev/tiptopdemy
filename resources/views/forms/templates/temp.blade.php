@if($item->type == \App\Modules\Form\FormItem::TYPE_SECTION)
    <li class="form-item uk-width-1-1 uk-margin-remove" style="padding-top: 10px">
        <div class="uk-grid-small uk-text-center" uk-grid>
            <div class="uk-width-auto@m">
                <div class="uk-tile uk-tile-secondary uk-box-shadow-small" style="border-radius: 10px 10px 0 0; padding: 5px 20px">
                    <p class="uk-h4">{{$item->title}}</p>
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
    <li class="form-item uk-width-{{$item->getWidth()}}@m uk-width-1-1@s uk-margin-remove">
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