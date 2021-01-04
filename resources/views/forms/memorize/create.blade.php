@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <style>
        .select2-container--default .select2-selection--multiple{
            border-radius: 2px !important;
            border: 1px solid #CED4DA;
            padding: 5px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple{
            border: 1px solid #0099FF !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($memorize)? __('main.Save changes') : __('main.submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($memorize))
            {!! Form::open(['url' => route('form.memorize.update', $memorize->hash_id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('form.memorize.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header')
        <div class="form-panel row">
            <div class=" col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Memorize term')}}</div>
                            <div class="col-lg-3 padding-0 margin-0">
                                {!! Form::text('title',!empty($memorize) ? $memorize->title : null,['class' => 'uk-input ','required' => true,'placeholder' => __('Memorize term')]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Notes')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <textarea class="uk-textarea memorize-description-editor" name="description" rows="15" placeholder="Add your notes hare ..">{{!empty($memorize) ? $memorize->description : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Group')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('tags[]', $tags, $selectedTags, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'memorize-tags', 'data-placeholder' => __('main.Create new tag'), 'style' => 'width:100%;']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Time to answer')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::number('time_to_answer',!empty($memorize) && !empty($memorize['properties']) ? $memorize['properties']['time_to_answer'] : 5,['class' => 'uk-input uk-width-1-3 ','required' => true, 'min' => 0]) !!}  in seconds
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Level')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('level', \App\Modules\Form\FormItem::MEMORIZE_LEVELS, !empty($memorize) && !empty($memorize['properties']) ? $memorize['properties']['level'] : null, ['class' => 'uk-select uk-width-1-3']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Answers')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div class="uk-text-right">
                                    <span class="uk-button uk-button-default add-item" onclick="addNewItem()"><span uk-icon="icon: plus-circle"></span> add answer</span>
                                </div>
                                <ul class="uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s uk-text-center items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                    @if(!empty($memorize['options']))
                                        @foreach($memorize['options'] as $id => $option)
                                        <li id="memorize-{{$id}}">
                                        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
                                            <div class="uk-margin-small-bottom uk-grid-collapse"  uk-grid>
                                                <div class="uk-width-expand@m">
                                                </div>
                                                <div class="uk-width-auto@m">
                                                    <span class="uk-sortable-handle uk-margin-small-right uk-text-center" uk-icon="icon: table"></span>
                                                    <span class="uk-text-center hover-danger" uk-icon="icon: trash" onclick="deleteItem(this)"></span>
                                                </div>
                                            </div>
                                            <div>
                                                <input type="hidden" name="item_id[]" value="{{$id}}">
                                                <textarea class="uk-textarea option-description memories-content-{{$id}}" name="item_description[{{$id}}]">{!! $option['description'] !!}</textarea>
                                            </div>
                                            <hr>
                                            <div>
                                                <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                    <div>
                                                        <label class="memorize-item-language-label memorize-item-en-label {{$option['lang'] == 'en' ? 'checked' : ''}}">
                                                            <input class="uk-radio" type="radio" name="item_lang[{{$id}}]" value="en" {{$option['lang'] == 'en' ? 'checked' : ''}}>
                                                            English
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="memorize-item-language-label memorize-item-ar-label {{$option['lang'] == 'ar' ? 'checked' : ''}}">
                                                            <input class="uk-radio" type="radio" name="item_lang[{{$id}}]" value="ar" {{$option['lang'] == 'ar' ? 'checked' : ''}}>
                                                            عربي
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="memorize-item-status-label memorize-item-status-correct-label {{$option['status'] == '1' ? 'checked' : ''}}">
                                                            <input class="uk-radio" type="radio" name="item_status[{{$id}}]" value="1" {{$option['status'] == '1' ? 'checked' : ''}}>
                                                            <i class="far fa-check-circle"></i> Correct
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="memorize-item-status-label memorize-item-status-incorrect-label {{$option['status'] == '0' ? 'checked' : ''}}">
                                                            <input class="uk-radio" type="radio" name="item_status[{{$id}}]" value="0" {{$option['status'] == '0' ? 'checked' : ''}}>
                                                            <i class="far fa-times-circle"></i> Incorrect
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-margin-small">
                                                <input type="text" class="uk-input" placeholder="Add Meaning here" name="item_default_title[{{$id}}]" value="{{$option['default_title']}}">
                                            </div>
                                        </div>
                                    </li>
                                        @endforeach
                                    @endif
                                </ul>
                                @if(false)
                                <div>
                                    <div class="uk-card uk-card-default uk-card-body uk-padding-small">
                                        <div>
{{--                                                <label class="uk-form-label"></label>--}}
                                            <textarea class="uk-textarea memories-content"></textarea>
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                <div>
                                                    <label class="memorize-item-language-label checked">
                                                        <input class="uk-radio" type="radio" name="lang">
                                                        English
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="memorize-item-language-label">
                                                        <input class="uk-radio" type="radio" name="lang">
                                                        عربي
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="memorize-item-status-label checked">
                                                        <input class="uk-radio" type="radio" name="lang">
                                                        <i class="far fa-check-circle"></i> Correct
                                                    </label>
                                                </div>
                                                <div>
                                                    <label class="memorize-item-status-label">
                                                        <input class="uk-radio" type="radio" name="lang">
                                                        <i class="far fa-times-circle"></i> Incorrect
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <input type="text" class="uk-input" placeholder="Add Meaning here">
                                        </div>
                                        <div class="uk-margin-small">
                                            <select class="uk-select">
                                                <option>Very Easy</option>
                                                <option class="uk-text-primary">Easy</option>
                                                <option class="uk-text-success" selected>Moderate</option>
                                                <option class="uk-text-warning">Hard</option>
                                                <option class="uk-text-danger">Expert</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

            {!! Form::close() !!}

    </section>
@endsection
@section('script')
    @include('partial.scripts._tinyemc')
    <script>
        $("#memorize-tags").select2({
            tags:true, // change to false to disable add new tags
        });



    </script>
    @include('forms.memorize._script')
{{--    <script src="{{asset('js/app.js')}}"></script>--}}

@endsection
