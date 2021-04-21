@extends('themes.'.getFrontendThemeName().'.v2.layout')
@section('title', $page_title)
@section('head')
{{--    <meta property="og:url"                content="http://www.nytimes.com/2015/02/19/arts/international/when-great-minds-dont-think-alike.html" />--}}
{{--    <meta property="og:type"               content="article" />--}}
{{--    <meta property="og:title"              content="When Great Minds Don’t Think Alike" />--}}
{{--    <meta property="og:description"        content="How much does culture influence creative thinking?" />--}}
{{--    <meta property="og:image"              content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />--}}
@endsection
@section('content')
    <section>
        <div class="store uk-container uk-margin-medium-bottom" style="background-color: transparent">
            {{--header--}}
            @include('partial.frontend._page-header')
            {{--body--}}
            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                <div>
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-1-4 uk-visible@m">
                            <div class="uk-card uk-card-default uk-card-body" style="padding: 10px">
                                @widget('home.blog.side_bar_menu', ['search_key' => $search_key])
                            </div>
                        </div>
                        <div class="uk-width-expand">
                            <div class="uk-grid-small uk-child-width-1-1@m" uk-grid="masonry: true">
                                <div>
                                    <post-show
                                        slug="{{$post->slug}}"
                                        commentable-id="{{$post->id}}"
                                        class-name="{{$className}}"
                                        user-id="{{$userId}}"
                                        user-name="{{$userName}}"
                                        user-profile-pic="{{$userProfilePic}}"
                                    ></post-show>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
