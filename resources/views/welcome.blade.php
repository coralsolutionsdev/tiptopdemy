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
        </section>
    @endif
@endsection