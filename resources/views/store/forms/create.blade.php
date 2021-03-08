@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
@endsection
@section('content')
    @if(!empty($form))
        {!! Form::open(['url' => route('store.form.update', [$lesson->slug, $form->hash_id]),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'class' => 'form']) !!}
    @else
        {!! Form::open(['url' => route('form.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'class' => 'form']) !!}
    @endif
    <div class="row">
        <div class="col-12" style="padding: 0px 18px 10px 5px">
            <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-margin-remove">
                <div class="uk-child-width-1-2" uk-grid>
                    <div>
                        @if(!empty($lesson) && !empty($product))
                            <a href="{{route('store.lessons.edit', [$product->slug, $lesson->slug])}}"><span class="uk-button uk-button-default" style="padding: 0 20px" uk-tooltip="{{__('main.Back')}}"><span uk-icon="icon: arrow-left"></span></span></a>
                        @else
                            <a href="{{route('form.templates.index')}}"><span class="uk-button uk-button-default" style="padding: 0 20px" uk-tooltip="{{__('main.Back')}}"><span uk-icon="icon: arrow-left"></span></span></a>
                        @endif
                        <span class="uk-button uk-button-default" style="padding: 0 20px" onclick="toggleSetting()" uk-tooltip="{{__('main.General settings')}}"><span uk-icon="icon: settings"></span></span>
                        <span class="uk-button uk-button-default reset-form">{{__('main.Reset')}}</span>
                        <span class="uk-button uk-button-default save-as-template" data-toggle="modal" data-target="#saveAsTemplate">{{__('main.save as Template')}}</span>
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
                            <input type="hidden" name="update_type" class="update-type">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row setting-panel">
        <div class="col-lg-12" style="padding: 0px 20px 10px 5px">
            @include('forms.templates._settings')
        </div>
    </div>

    <div class="row form-panel">
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
    @include('forms.templates._save_template')
@endsection
@section('script')
    @include('partial.scripts._tinyemc')
    @include('forms._scripts')
@endsection
