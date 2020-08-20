@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">

@endsection
@section('content')
    @if(!empty($form))
        {!! Form::open(['url' => route('form.templates.update', $form->hash_id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'class' => 'form']) !!}
    @else
        {!! Form::open(['url' => route('form.templates.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'class' => 'form']) !!}
    @endif
    <div class="row">
        <div class="col-12" style="padding: 0px 18px 10px 5px">
            <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-margin-remove">
                <div class="uk-child-width-1-2" uk-grid>
                    <div>
                        <a href="{{route('form.templates.index')}}"><span class="uk-button uk-button-default" style="padding: 0 20px" uk-tooltip="{{__('main.Back')}}"><span uk-icon="icon: arrow-left"></span></span></a>
                        <span class="uk-button uk-button-default" style="padding: 0 20px" data-toggle="modal" data-target="#formSettingModal" uk-tooltip="{{__('main.General settings')}}"><span uk-icon="icon: settings"></span></span>
                        <span class="uk-button uk-button-default reset-form">{{__('main.Reset')}}</span>
                    </div>
                    <div class="uk-text-right">
                        @if(empty($form))
                            <span class="uk-button uk-button-primary uk-align-right submit-form">{{__('main.Save')}}</span>
                        @else
                            @if($form->type == \App\Modules\Form\Form::TYPE_FORM)
                            <span class="uk-text-success pl-1 pr-1"> {{__('main.version')}}: {{$form->version}}.0</span>
                            <span class="uk-button uk-button-default btn-update update-as-new">{{__('main.Save as new ver.')}}</span>
                            @endif
                            <span class="uk-button uk-button-primary btn-update">{{__('main.Save')}}</span>
                        @endif
                    </div>
                </div>
                <div>
                @include('forms.templates._settings')
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3" style="padding: 0px 5px">
            @include('forms.templates._items_list')
        </div>
        <div class="col-lg-9">
            <ul id="form-items" class="uk-grid-small" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                <li class="uk-width-1-1 uk-margin-remove pr-1 pl-1 pt-0 no-items">
                    <div class="uk-placeholder uk-text-center bg-white uk-text-meta items-message">
                        {{__('main.There is no form items yet, please select new item from the items list')}}.
                    </div>
                </li>
            </ul>
        </div>
    </div>
    {!! Form::close() !!}
    @include('forms.templates._items')
    @if(false)
    <section>
        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_SECTION}}" style="display: none">
            <div class="item" style="height: 100%">
                <div class="front uk-card uk-card-default uk-secondary-bg uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Section')}}
                    <span class="uk-align-right">
{{--                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>--}}
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove pt-0">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title uk-secondary-bg uk-text-primary" type="text" placeholder="" value="{{__('main.Section Title')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description uk-secondary-bg" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                    </div>
                </div>
            </div>
        </li>


        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_SHORT_ANSWER}}" style="display: none">
            <div>
                <div class="front uk-card uk-card-default uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Short text')}}
                    <span class="uk-align-right">
                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title input-title" type="text" placeholder="" value="{{__('main.Press here to edit the default question.')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                        <div class="uk-margin-small">
                            <input class="uk-input" type="text" placeholder="" disabled>
                        </div>
                        <div class="uk-margin-small item-config" style="display: none">
                            <ul uk-accordion>
                                <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">{{__('main.General settings')}}</a>
                                    <div class="uk-accordion-content uk-placeholder p-1" style="margin:10px 0px">
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Remark')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-score" type="text" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Placeholder')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-placeholder" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Difficulty')}} (1 - 10)</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-difficulty" type="number" min="1" max="5" placeholder="" value="5">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Source')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> {{__('main.Internal')}}</label></div>
                                                <div><label><input class="uk-radio input-source-external" type="radio" name="radio1" value="1"> {{__('main.External')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Recommending')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-recommended" type="radio" name="radio1" value="1"> {{__('main.Recommended')}}</label></div>
                                                <div><label><input class="uk-radio input-not-recommended" type="radio" name="radio1" value="0"> {{__('main.Not recommended')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Tags')}}</label>
                                            <div class="uk-form-controls">
                                                {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Width')}}</a>
                                    <div class="uk-accordion-content uk-text-center uk-placeholder p-1" style="margin: 10px 0px">
                                        <div class="uk-grid-collapse" uk-grid>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-3@m p-1">
                                                <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                                    1/3
                                                </div>
                                            </div>
                                            <div class="uk-width-2-3@m p-1">
                                                <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                                    2/3
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1@m p-1">
                                                <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                                    100%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_PARAGRAPH}}" style="display: none">
            <div class="item" style="height: 100%">
                <div class="front uk-card uk-card-default uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Long text')}}
                    <span class="uk-align-right">
                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title" type="text" placeholder="" value="{{__('main.Press here to edit the default question.')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                        <div class="uk-margin-small">
                            <textarea class="uk-textarea" rows="4" disabled></textarea>
                        </div>
                        <div class="uk-margin-small item-config" style="display: none">
                            <ul uk-accordion>
                                <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">{{__('main.General settings')}}</a>
                                    <div class="uk-accordion-content uk-placeholder p-1" style="margin:10px 0px">
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Remark')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-score" type="text" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Placeholder')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-placeholder" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Difficulty')}} (1 - 10)</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-difficulty" type="number" min="1" max="5" placeholder="" value="5">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Source')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> {{__('main.Internal')}}</label></div>
                                                <div><label><input class="uk-radio input-source-external" type="radio" name="radio1" value="1"> {{__('main.External')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Recommending')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-recommended" type="radio" name="radio1" value="1"> {{__('main.Recommended')}}</label></div>
                                                <div><label><input class="uk-radio input-not-recommended" type="radio" name="radio1" value="0"> {{__('main.Not recommended')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Tags')}}</label>
                                            <div class="uk-form-controls">
                                                {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Width')}}</a>
                                    <div class="uk-accordion-content uk-text-center uk-placeholder p-1" style="margin: 10px 0px">
                                        <div class="uk-grid-collapse" uk-grid>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-3@m p-1">
                                                <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                                    1/3
                                                </div>
                                            </div>
                                            <div class="uk-width-2-3@m p-1">
                                                <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                                    2/3
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1@m p-1">
                                                <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                                    100%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_SINGLE_CHOICE}}" style="display: none">
            <div class="item" style="height: 100%">
                <div class="front uk-card uk-card-default uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Single choice')}}
                    <span class="uk-align-right">
                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title" type="text" placeholder="" value="{{__('main.Press here to edit the default question.')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                        <div class="uk-margin-small item-review-options">
                        </div>
                        <div class="uk-margin-small item-config" style="display: none">
                            <ul uk-accordion>
                                <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Options')}}</a>
                                    <div class="uk-accordion-content">
                                        <div class="uk-placeholder p-1" style="margin: 0px">
                                            <div class="row pb-1">
                                                <div class="col-10"></div>
                                                <div class="col-1">{{__('main.Default')}}</div>
                                                <div class="col-1">{{__('main.Delete')}}</div>
                                            </div>
                                            <ul class="uk-grid-collapse uk-child-width-1-1 item-options-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                            </ul>
                                            <div class="pt-2 uk-text-right">
                                                <span class="uk-button uk-button-default add-item-option"><span uk-icon="icon: plus-circle"></span> {{__('main.Add Option')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.General settings')}}</a>
                                    <div class="uk-accordion-content uk-placeholder p-1" style="margin:10px 0px">
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Remark')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-score" type="text" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Placeholder')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-placeholder" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Difficulty')}} (1 - 10)</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-difficulty" type="number" min="1" max="5" placeholder="" value="5">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Source')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> {{__('main.Internal')}}</label></div>
                                                <div><label><input class="uk-radio input-source-external" type="radio" name="radio1" value="1"> {{__('main.External')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Recommending')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-recommended" type="radio" name="radio1" value="1"> {{__('main.Recommended')}}</label></div>
                                                <div><label><input class="uk-radio input-not-recommended" type="radio" name="radio1" value="0"> {{__('main.Not recommended')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Tags')}}</label>
                                            <div class="uk-form-controls">
                                                {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Width')}}</a>
                                    <div class="uk-accordion-content uk-text-center uk-placeholder p-1" style="margin: 10px 0px">
                                        <div class="uk-grid-collapse" uk-grid>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-3@m p-1">
                                                <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                                    1/3
                                                </div>
                                            </div>
                                            <div class="uk-width-2-3@m p-1">
                                                <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                                    2/3
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1@m p-1">
                                                <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                                    100%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_MULTI_CHOICE}}" style="display: none">
            <div class="item" style="height: 100%">
                <div class="front uk-card uk-card-default uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Multiple choice')}}
                    <span class="uk-align-right">
                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title" type="text" placeholder="" value="{{__('main.Press here to edit the default question.')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                        <div class="uk-margin-small">
                            <div class="uk-margin-small uk-form-controls item-review-options">
                            </div>
                        </div>
                        <div class="uk-margin-small item-config" style="display: none">
                            <ul uk-accordion>
                                <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Options')}}</a>
                                    <div class="uk-accordion-content">
                                        <div class="uk-placeholder p-1" style="margin: 0px">
                                            <div class="row pb-1">
                                                <div class="col-10"></div>
                                                <div class="col-1">{{__('main.Default')}}</div>
                                                <div class="col-1">{{__('main.Delete')}}</div>
                                            </div>
                                            <ul class="uk-grid-collapse uk-child-width-1-1 item-options-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                            </ul>
                                            <div class="pt-2 uk-text-right">
                                                <span class="uk-button uk-button-default add-item-option"><span uk-icon="icon: plus-circle"></span> {{__('main.Add Option')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.General settings')}}</a>
                                    <div class="uk-accordion-content uk-placeholder p-1" style="margin:10px 0px">
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Remark')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-score" type="text" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Placeholder')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-placeholder" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Difficulty')}} (1 - 10)</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-difficulty" type="number" min="1" max="5" placeholder="" value="5">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Source')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> {{__('main.Internal')}}</label></div>
                                                <div><label><input class="uk-radio input-source-external" type="radio" name="radio1" value="1"> {{__('main.External')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Recommending')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-recommended" type="radio" name="radio1" value="1"> {{__('main.Recommended')}}</label></div>
                                                <div><label><input class="uk-radio input-not-recommended" type="radio" name="radio1" value="0"> {{__('main.Not recommended')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Tags')}}</label>
                                            <div class="uk-form-controls">
                                                {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Width')}}</a>
                                    <div class="uk-accordion-content uk-text-center uk-placeholder p-1" style="margin: 10px 0px">
                                        <div class="uk-grid-collapse" uk-grid>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-3@m p-1">
                                                <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                                    1/3
                                                </div>
                                            </div>
                                            <div class="uk-width-2-3@m p-1">
                                                <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                                    2/3
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1@m p-1">
                                                <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                                    100%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_DROP_DOWN}}" style="display: none">
            <div class="item" style="height: 100%">
                <div class="front uk-card uk-card-default uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Drop menu')}}
                    <span class="uk-align-right">
                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title" type="text" placeholder="" value="{{__('main.Press here to edit the default question.')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                        <div class="uk-margin-small">
                            <select class="uk-select item-review-options" id="form-stacked-select">
                            </select>
                        </div>
                        <div class="uk-margin-small item-config" style="display: none">
                            <ul uk-accordion>
                                <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Options')}}</a>
                                    <div class="uk-accordion-content">
                                        <div class="uk-placeholder p-1" style="margin: 0px">
                                            <div class="row pb-1">
                                                <div class="col-10"></div>
                                                <div class="col-1">{{__('main.Default')}}</div>
                                                <div class="col-1">{{__('main.Delete')}}</div>
                                            </div>
                                            <ul class="uk-grid-collapse uk-child-width-1-1 item-options-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                            </ul>
                                            <div class="pt-2 uk-text-right">
                                                <span class="uk-button uk-button-default add-item-option"><span uk-icon="icon: plus-circle"></span> {{__('main.Add Option')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.General settings')}}</a>
                                    <div class="uk-accordion-content uk-placeholder p-1" style="margin:10px 0px">
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Remark')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-score" type="text" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Placeholder')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-placeholder" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Difficulty')}} (1 - 10)</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-difficulty" type="number" min="1" max="5" placeholder="" value="5">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Source')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> {{__('main.Internal')}}</label></div>
                                                <div><label><input class="uk-radio input-source-external" type="radio" name="radio1" value="1"> {{__('main.External')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Recommending')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-recommended" type="radio" name="radio1" value="1"> {{__('main.Recommended')}}</label></div>
                                                <div><label><input class="uk-radio input-not-recommended" type="radio" name="radio1" value="0"> {{__('main.Not recommended')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Tags')}}</label>
                                            <div class="uk-form-controls">
                                                {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Width')}}</a>
                                    <div class="uk-accordion-content uk-text-center uk-placeholder p-1" style="margin: 10px 0px">
                                        <div class="uk-grid-collapse" uk-grid>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-3@m p-1">
                                                <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                                    1/3
                                                </div>
                                            </div>
                                            <div class="uk-width-2-3@m p-1">
                                                <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                                    2/3
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1@m p-1">
                                                <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                                    100%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 templateType-{{\App\Modules\Form\Form::TYPE_FILL_THE_BLANK}}" style="display: none">
            <div class="item" style="height: 100%">
                <div class="front uk-card uk-card-default uk-card-body uk-padding-small">
                    <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> {{__('main.Fill the blank')}}
                    <span class="uk-align-right">
                        <span class="open-config hover-primary" uk-icon="icon: cog" href=""></span>
                        <span class="hover-danger remove-form-item" uk-icon="icon: trash"></span>
                    </span>
                    <div class="uk-margin-remove">
                        <div class="uk-margin-remove">
                            <input type="hidden" name="" class="input-id">
                            <input type="hidden" name="" class="input-type">
                            <input type="hidden" name="" class="input-width" value="1-1">
                            <input class="uk-input invisible-input input-large-text input-title" type="text" placeholder="" value="{{__('main.Press here to edit the default question.')}}">
                        </div>
                        <div class="uk-margin-remove">
                            <span class="hover-danger reset-description" uk-icon="icon: close" style="position: absolute; right: 5px; padding: 10px"></span>
                            <input class="uk-input invisible-input description input-description" type="text" placeholder="{{__('main.Description')}} ..." value="{{__('main.You can add description and instructions, or remove it from the question settings')}}">
                        </div>
                        <div class="uk-margin-small">
                            <div class="uk-text-right">
                                <span class="btn btn-primary insert-blank"><span class="" uk-icon="icon: plus-circle"></span> {{__('main.Add blank')}}</span>
                            </div>
                            <div class="editable-div fill-the-blank-div border-secondary p-2 mt-1" contenteditable="true" >
                            </div>
                            <input type="hidden" name="" class="input-blanks" value="">
                            <!-- User interaction is required by the browser -->
                        </div>
                        <div class="uk-margin-small item-config" style="display: none">
                            <ul uk-accordion>
                                <li class="uk-open">
                                    <a class="uk-accordion-title" href="#">{{__('main.General settings')}}</a>
                                    <div class="uk-accordion-content uk-placeholder p-1" style="margin:10px 0px">
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Remark')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-score" type="text" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Placeholder')}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-placeholder" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Difficulty')}} (1 - 10)</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-input input-difficulty" type="number" min="1" max="5" placeholder="" value="5">
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Source')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> {{__('main.Internal')}}</label></div>
                                                <div><label><input class="uk-radio input-source-external" type="radio" name="radio1" value="1"> {{__('main.External')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Recommending')}}</label>
                                            <div class="uk-form-controls">
                                                <div><label><input class="uk-radio input-recommended" type="radio" name="radio1" value="1"> {{__('main.Recommended')}}</label></div>
                                                <div><label><input class="uk-radio input-not-recommended" type="radio" name="radio1" value="0"> {{__('main.Not recommended')}}</label></div>
                                            </div>
                                        </div>
                                        <div class="uk-margin-small">
                                            <label class="uk-form-label" for="">{{__('main.Tags')}}</label>
                                            <div class="uk-form-controls">
                                                {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">{{__('main.Question Width')}}</a>
                                    <div class="uk-accordion-content uk-text-center uk-placeholder p-1" style="margin: 10px 0px">
                                        <div class="uk-grid-collapse" uk-grid>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-2@m p-1">
                                                <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                                    1/2
                                                </div>
                                            </div>
                                            <div class="uk-width-1-3@m p-1">
                                                <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                                    1/3
                                                </div>
                                            </div>
                                            <div class="uk-width-2-3@m p-1">
                                                <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                                    2/3
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1@m p-1">
                                                <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                                    100%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </section>
    @endif
@endsection
@section('script')
    @include('partial.scripts._tinyemc')
    @include('forms._scripts')
@endsection
