@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('content')
    <section>
        @include('partial.frontend._page-header')
        <div class="uk-background-default pt-25">
            <div class="uk-container">
                @if(!empty($albums) && $albums->count() > 0)
                <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-text-center uk-grid-small" uk-grid="masonry: true">
                    @foreach($albums as $album)
                        <div class="uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
                            <a class="uk-inline" href="{{route('gallery.album.show', $album->slug)}}" data-caption="Caption 1">
                                <img src="{{asset_image($album->getCoverImage())}}" alt="">
                                <div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
                                    <p class="uk-h4 uk-margin-remove " style="color: black">{{$album->description}} </p>
                                </div>
                            </a>
                            <p class="uk-margin-small-top uk-text-capitalize">{{$album->title}} ({{$album->getImagesCount()}})</p>
                        </div>
                    @endforeach
                </div>
                <div class="uk-padding">
                    {!! $albums->links() !!}
                </div>
                @else
                    <div class="uk-child-width-1-1@m" uk-grid>
                        <div>
                            <div class="uk-card uk-card-clear">
                                <div class="uk-card-body uk-padding uk-text-center uk-placeholder">
                                    <span class="uk-text-muted" uk-icon="icon: ban; ratio: 3"></span>
                                    <h5 class="uk-margin-small">No records found</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection