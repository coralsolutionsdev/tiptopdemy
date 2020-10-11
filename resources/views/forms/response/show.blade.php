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
                            <div class="uk-width-expand">
                                <h3 class="text-highlighted">{{$response->title}}</h3>
                                <p>{!! $response->description !!}</p>
                            </div>
                            <div class="uk-width-1-5 uk-text-center">
                                <div>
                                    @if($response->score_info['passing_score_type'] == 1)
                                    <h2 class="text-highlighted">{{$response->score_info['score_percentage']}} / 100 %</h2>
                                    @else
                                    <h2 class="text-highlighted">{{$response->score_info['achieved_score']}} / {{$response->score_info['total_score']}}</h2>
                                    @endif
                                </div>
                                    @if($response->score_info['passing_score_type'] == 1)
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
                if (blankStatus == 3){
                    blankStatusColorClass = 'danger';
                    blankStatusIcon = 'times';
                }
                var html = '<span uk-tooltip="'+blankScoreText+'" class="uk-text-'+blankStatusColorClass+'" style="padding: 0 5px">'+blankValue+' <i class="far fa-'+blankStatusIcon+'-circle"></i></span>';
                blank.html(html);
            });
        });
    </script>
@endsection
