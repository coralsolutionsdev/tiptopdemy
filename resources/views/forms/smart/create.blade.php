@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
    <style>
        html, body{
            height: 100%;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')
{{--    @if(!empty($form))--}}
{{--        {!! Form::open(['url' => route('form.templates.update', $form->hash_id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'class' => 'form']) !!}--}}
{{--    @else--}}
{{--        {!! Form::open(['url' => route('form.templates.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'class' => 'form']) !!}--}}
{{--    @endif--}}
@if(false)
    <div class="row">
        <div class="col-12" style="padding: 0px 18px 10px 5px">
            <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-margin-remove">
                <div class="uk-child-width-1-2" uk-grid>
                    <div>
                        <a href="{{route('form.templates.index')}}"><span class="uk-button uk-button-default" style="padding: 0 20px" uk-tooltip="{{__('main.Back')}}"><span uk-icon="icon: arrow-left"></span></span></a>
                        <span class="uk-button uk-button-default" style="padding: 0 20px" onclick="toggleSetting()" uk-tooltip="{{__('main.General settings')}}"><span uk-icon="icon: settings"></span></span>
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
            </div>
        </div>
    </div>
    <div class="row setting-panel">
        <div class="col-lg-12" style="padding: 0px 20px 10px 5px">
            @include('forms.templates._settings')
        </div>
    </div>
@endif

    <div id="vue-app">
        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
            <div class="uk-grid-small uk-text-center" uk-grid>
                <div class="uk-width-auto">
                    <a href="{{route('form.templates.index')}}"><span class="uk-button uk-button-default" style="padding: 0 20px" uk-tooltip="{{__('main.Back')}}"><span uk-icon="icon: arrow-left"></span></span></a>
                    <span class="uk-button uk-button-default" style="padding: 0 20px" onclick="toggleSetting()" uk-tooltip="{{__('main.General settings')}}"><span uk-icon="icon: settings"></span></span>
                    <span class="uk-button uk-button-default reset-form">{{__('main.Reset')}}</span>
                </div>
                <div class="uk-width-expand">
                </div>
                <div class="uk-width-auto">
                    <span class="uk-button uk-button-primary uk-align-right submit-form">{{__('main.Save')}}</span>
                </div>
            </div>
        </div>
        <div class="uk-margin">
            <smart-form-create></smart-form-create>
        </div>
    </div>
    <script>
        var settingMode = false;
        function refreshSettingMode(){
            if (settingMode){
                $('.setting-panel').show();
                $('.form-panel').hide();
            }else {
                $('.form-panel').show();
                $('.setting-panel').hide();
            }
        }
        refreshSettingMode();

        function toggleSetting(){
            settingMode = !settingMode;
            refreshSettingMode();
        }
    </script>

{{--    {!! Form::close() !!}--}}
    @include('partial.scripts._tinyemc')
    <script src="{{asset('js/app.js?v=202103112140')}}"></script>

@endsection
