<div class="uk-grid-collapse" uk-grid>
    <div class="uk-width-3-4@m">
        <h5 class="uk-card-title">{{$item->title}}</h5>
        <p class="uk-text-meta">
            {!! $item->description !!}
        </p>
    </div>
    <div class="uk-width-1-4@m uk-text-{{getFloatKey('end')}}">
        @if(!empty($item->getPropertiesValue('score')))
            <span class="uk-text-success">{{$item->getPropertiesValue('score')}} {{ trans_choice('main.Marks', $item->getPropertiesValue('score'))}}</span><br>
        @endif
        @if(!empty($item->getPropertiesValue('difficulty')))
            <span class="uk-text-warning">{{__('main.Difficulty')}} : {{$item->getPropertiesValue('difficulty')}}</span><br>
        @endif
    </div>
</div>