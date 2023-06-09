@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <style>
    </style>
@endsection
@section('content')
    <section>
        <div class="store uk-container uk-margin-medium-bottom">
            {{--header--}}
            @include('partial.frontend._page-header')
            {{--body--}}
            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-box-shadow-small">
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-6@m uk-width-1-1 uk-flex uk-flex-middle uk-flex-center">
                                <div>
                                    @if($response->score_info['passing_score_status'] != 1 && !empty($response->getFormUrl()))
                                        <a href="{{$response->getFormUrl()}}" class="uk-button uk-button-secondary uk-margin-small uk-width-1-1">{{__('main.Re try')}}</a>
                                    @endif
                                    <a href="" id="backURl" class="uk-button uk-button-default uk-width-1-1">{{__('main.Back to lesson')}}</a>
                                </div>
                            </div>
                            <div class="uk-width-expand@m uk-width-1-1">
                                <div class="uk-grid-collapse uk-child-width-1-1 uk-text-center" uk-grid>
                                    <div>
                                        <h3 class="text-highlighted">{{$response->title}}</h3>
                                        <p>{!! $response->description !!}</p>
                                    </div>
                                    <div class="uk-flex uk-flex-center">
                                        <div class="uk-width-1-3@m">
                                            @if($response->score_info['passing_score_status'] == 1)
                                                <div class="uk-alert-success uk-margin-small" uk-alert>
                                                    {{__('main.Passed successfully')}}
                                                </div>
                                            @else
                                                <div class="uk-alert-danger uk-margin-small" uk-alert>
                                                    {{__('main.Failed')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="uk-width-1-5@m uk-width-1-1 uk-flex uk-flex-middle uk-flex-center">
                                @if($response->score_info['passing_score_type'] == 1)
                                <h2 class="{{$response->score_info['passing_score_status'] == 1 ? 'uk-text-success' : 'uk-text-danger'}}">{{$response->score_info['score_percentage']}} / 100 %</h2>
                                @else
                                <h2 class="{{$response->score_info['passing_score_status'] == 1 ? 'uk-text-success' : 'uk-text-danger'}}">{{$response->score_info['achieved_score']}} / {{$response->score_info['total_score']}}</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="quiz-section bg-secondary pt-25">
                        <div class="uk-container">
                            {{--Form--}}
                            <div class="uk-margin" style="direction: {{$response->form->getDirection()}};">
                                {{--Form sections--}}
                                <div class="uk-margin-medium-top" style="">
                                    @if(!empty($response) && !empty($response->data))
                                        <ul class="uk-list">
                                            @forelse($response->data as $sectionKey => $sectionItems)
                                                @if(!is_null($displayType) && $displayType == 1)
                                                    Under development process
                                                @else
                                                    @include('forms.response.displays._traditional')
                                                @endif
                                            @empty
                                                no Items message
                                            @endforelse
                                        </ul>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const url = urlParams.get('back')
        console.log(url);
        $('#backURl').attr('href',url)

        var blankItemsParagraphs = $('.item-fill-the-blank-paragraph');
        $.each(blankItemsParagraphs, function (){
            var paragraph = $(this);
            var paragraphItem = paragraph.closest('.quiz-item');
            var paragraphItemId = paragraphItem.attr('id');
            var paragraphItemBlanks = $('.item-'+paragraphItemId+'-paragraph-blank');
            $.each(paragraphItemBlanks, function (key, index){
                var blank = $(this);
                var blankValue = $('.item-'+paragraphItemId+'-answer-'+key+'-value').val();
                var blankStatus = $('.item-'+paragraphItemId+'-answer-'+key+'-status').val();
                var blankScore = $('.item-'+paragraphItemId+'-answer-'+key+'-score').val();
                var blankScoreText = blankScore + " {{trans_choice('main.Marks', 1)}}";
                var blankStatusColorClass = 'success';
                var blankStatusIcon = 'check';
                if (blankStatus == 3 || blankStatus == undefined){
                    blankStatusColorClass = 'danger';
                    blankStatusIcon = 'times';
                }
                var html = `<span class="uk-text-`+blankStatusColorClass+`"><i class="far fa-`+blankStatusIcon+`-circle"></i></span>`;
                if (blankValue != undefined){
                    var html = '<span class="uk-text-'+blankStatusColorClass+'" style="padding: 0 5px">'+blankValue+' <i class="far fa-'+blankStatusIcon+'-circle"></i></span>';
                }
                blank.html(html);
            });
        });
    </script>
@endsection
