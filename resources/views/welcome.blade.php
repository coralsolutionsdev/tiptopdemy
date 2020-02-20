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
            <div>
                Welcome to {{getSite()->name}}
            </div>
        </section>
    @endif
@endsection