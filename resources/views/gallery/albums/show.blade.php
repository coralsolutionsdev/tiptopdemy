@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('content')
    <section>
        @include('partial.frontend._page-header')
        <div class="uk-background-default pt-25">
            <div class="uk-container">
                @if(!empty($images) && $images->count() > 0)
                <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-text-center uk-grid-small" uk-grid="masonry: true" uk-lightbox="animation: fade">
                    @foreach($images as $image)
                    <div class="uk-inline-clip uk-transition-toggle uk-light" tabindex="0">
                        <a class="uk-inline" href="{{asset_image($image->image)}}" data-caption="{{$image->description}}">
                            <img src="{{asset_image($image->image)}}" alt="">
                            <div class="uk-position-center">
                                <span class="uk-transition-fade" uk-icon="icon: plus; ratio: 2"></span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="uk-padding">
                    {!! $images->links() !!}
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
    <script>
        $('.pagination').addClass('uk-pagination').addClass('uk-flex-center');
    </script>
@endsection