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
            <div class="">
                <div class="uk-flex uk-flex-center ">
                    <h1>
                        Welcome to <span class="uk-text-primary">{{getSite()->name}}</span>
                    </h1>
                </div>
            </div>
            <div class="ui grid">
                <div class="four wide column">1</div>
                <div class="four wide column">2</div>
                <div class="four wide column">3</div>
                <div class="four wide column">4</div>
                <div class="two wide column">5</div>
                <div class="eight wide column">6</div>
                <div class="six wide column">7</div>
            </div>
        </section>
    @endif
@endsection