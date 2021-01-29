@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple{
            border-radius: 2px !important;
            border: 1px solid #CED4DA;
            padding: 5px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple{
            border: 1px solid #0099FF !important;
        }
        html,body{

        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($memorize)? __('main.Save changes') : __('main.submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($form))
            {!! Form::open(['url' => $storeRoute,'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => $storeRoute,'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
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
                                {!! Form::text('title',!empty($form) ? $form->title : null,['class' => 'uk-input ','required' => true,'placeholder' => __('Memorize term')]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Notes')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <textarea class="uk-textarea memorize-description-editor" name="description" rows="15" placeholder="Add your notes hare ..">{{!empty($form) ? $form->description : ''}}</textarea>
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
                                {!! Form::number('time_to_answer',!empty($form) && !empty($form['properties']) ? $form['properties']['time_to_answer'] : 5,['class' => 'uk-input uk-width-1-3 ','required' => true, 'min' => 0]) !!}  in seconds
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Memorize question')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('item_question',!empty($form) && !empty($form['properties']) && !empty($form['properties']['item_question']) ? $form['properties']['item_question'] : '',['class' => 'uk-input uk-width-1-1 ', 'placeholder' => 'What is your memorize question? (optional)']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Level')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('level', \App\Modules\Form\FormItem::MEMORIZE_LEVELS, !empty($form) && !empty($form['properties']) ? $form['properties']['level'] : null, ['class' => 'uk-select uk-width-1-3']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2">{{__('Answers')}}</div>
                            <div class="col-lg-10 padding-0 margin-0 memorize-groups-lists">
                                <div class="uk-placeholder uk-margin-small">

                                    <div class="uk-margin-small">
                                        <input name="form_item_type_title[{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM}}]" type="text" class="uk-input uk-form-width-medium memorize-group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM}}-title" value="English" style="margin-right: 5px"> <span class="uk-button uk-button-default add-memorize-item add-item hover-primary" onclick="addFormItem({{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM}})"><span uk-icon="icon: plus-circle"></span></span>
                                    </div>
                                    <ul class="uk-grid-small uk-child-width-1-3 uk-text-center group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM}}-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                        @if(false)
                                        <li>
                                            <div class="memorize-item uk-grid-small" uk-grid>
                                                <div class="uk-width-1-1"><input type="text" class="uk-input" placeholder="Word item"></div>
                                                <div class="uk-width-expand">
                                                    <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-correct-label checked">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="1">
                                                                <i class="far fa-check-circle"></i> Correct
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-incorrect-label">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="0">
                                                                <i class="far fa-times-circle"></i> Incorrect
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-auto">
                                                    <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>

                                </div>
                                <div class="uk-placeholder uk-margin-small">

                                    <div class="uk-margin-small">
                                        <input name="form_item_type_title[{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A}}]" type="text" class="uk-input uk-form-width-medium memorize-group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A}}-title" value="عربي" style="margin-right: 5px"> <span class="uk-button uk-button-default add-memorize-item add-item hover-primary" onclick="addFormItem({{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A}})"><span uk-icon="icon: plus-circle"></span></span>
                                    </div>
                                    <ul class="uk-grid-small uk-child-width-1-3 uk-text-center group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A}}-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                        @if(false)
                                        <li>
                                            <div class="memorize-item uk-grid-small" uk-grid>
                                                <div class="uk-width-1-1"><input type="text" class="uk-input" placeholder="Word item"></div>
                                                <div class="uk-width-expand">
                                                    <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-correct-label checked">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="1">
                                                                <i class="far fa-check-circle"></i> Correct
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-incorrect-label">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="0">
                                                                <i class="far fa-times-circle"></i> Incorrect
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-auto">
                                                    <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>

                                </div>
                                <div class="uk-placeholder uk-margin-small">

                                    <div class="uk-margin-small">
                                        <input name="form_item_type_title" type="text" class="uk-input uk-form-width-medium memorize-group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_IMAGE}}-title" value="Image" disabled style="margin-right: 5px"> <span class="uk-button uk-button-default add-memorize-item add-item hover-primary" onclick="addFormItem({{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_IMAGE}})"><span uk-icon="icon: plus-circle"></span></span>
                                    </div>
                                    <ul class="uk-grid-small uk-child-width-1-3 uk-text-center group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_IMAGE}}-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid="masonry: true">
                                        @if(false)
                                        <li>
                                            <div class="memorize-item uk-grid-small" uk-grid>
                                                <div class="uk-width-1-1">
                                                    <div class="uk-grid-small" uk-grid>
                                                        <div class="uk-width-1-1">
                                                            <img src="{{asset_image('assets/no-image.png')}}"  sizes="(min-width: 650px) 650px, 100vw" width="650" height="" alt="" uk-img>
                                                        </div>
                                                        <div class="uk-width-1-1"><span class="uk-button uk-button-default uk-width-1-1">Change</span></div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-correct-label checked">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="1">
                                                                <i class="far fa-check-circle"></i> Correct
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-incorrect-label">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="0">
                                                                <i class="far fa-times-circle"></i> Incorrect
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-auto">
                                                    <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>

                                </div>
                                <div class="uk-placeholder uk-margin-small">

                                    <div class="uk-margin-small">
                                        <input name="form_item_type_title" type="text" class="uk-input uk-form-width-medium memorize-group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_AUDIO}}-title" value="Audio" disabled style="margin-right: 5px"> <span class="uk-button uk-button-default add-memorize-item add-item hover-primary" onclick="addFormItem({{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_AUDIO}})"><span uk-icon="icon: plus-circle"></span></span>
                                    </div>
                                    <ul class="uk-grid-small uk-child-width-1-3 uk-text-center group-{{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_AUDIO}}-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                        @if(false)
                                        <li>
                                            <div class="memorize-item uk-grid-small" uk-grid>
                                                <div class="uk-width-1-1">
                                                    <div class="uk-grid-small" uk-grid>
                                                        <div class="uk-width-1-1">
                                                            <audio controls>
                                                                <source src="" type="audio/mpeg" class="audio-file" controls controlsList="nodownload">
                                                            </audio>
                                                        </div>
                                                        <div class="uk-width-1-1"><span class="uk-button uk-button-default uk-width-1-1">Change</span></div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-correct-label checked">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="1">
                                                                <i class="far fa-check-circle"></i> Correct
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <label class="memorize-item-status-label memorize-item-status-incorrect-label">
                                                                <input class="uk-radio" type="radio" name="item_status[]" value="0">
                                                                <i class="far fa-times-circle"></i> Incorrect
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-auto">
                                                    <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
            <div id="deleted-items">
            </div>

            {!! Form::close() !!}
            <div>
                <div id="mediaModal"  class="uk-modal-container" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h5 class="">Media libaray</h5>
                        </div>
                        <div id="vue-app">
                            <file-manager v-bind:insertmode="true"></file-manager>
                        </div>
                    </div>
                </div>
            </div>


    <script src="{{asset('js/app.js?v=202101290410')}}"></script>

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

@endsection
