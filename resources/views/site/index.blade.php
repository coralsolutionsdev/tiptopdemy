@extends('themes.'.getAdminThemeName().'.layout')
@section('title', trans('main._setting'))
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('head')
    <!-- MiniColors -->
    <script src="{{asset('plugins/color_picker/jquery.minicolors.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/color_picker/jquery.minicolors.css')}}">
@endsection

@section('content')
<section>
    {!! Form::open(['url' => route('setting.update', getSite()->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}

    @include('manage.partials._page-header')
    <div class="form-panel row">
        <div class="col-lg-12">
            <div class="row col-lg-12 padding-0 margin-0">
                <div class="col-lg-7 properties">
                    <div class="card border-light" style="min-height: 350px">
                        <div class="card-body">
                            <p>{{__('Basic info')}}</p>
                            <hr>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Site name')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::text('name',getSite()->name,['class' => 'form-control title','required' => true,'placeholder' => 'Site name']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Description')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::textarea('description',getSite()->description,['class' => 'form-control','rows' => '5']) !!}

                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Language')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::select('lang',[null=>'-- Please Select Category --'] + $languages,getSite()->lang,['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Layout')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::select('layout_id',$layouts,getSite()->layout_id,['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Theme')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::select('theme',\App\Site::THEMES_ARRAY,getSite()->theme,['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Theme Primary Color')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="text" id="wheel-color_picker" name="frontend_primary_color" class="form-control color_picker" data-control="wheel" value="{{getFrontEndColor()}}">
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Admin theme')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::select('admin_theme',\App\Site::ADMIN_THEMES_ARRAY,getAdminThemeName(),['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Theme Primary Color')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="text" id="wheel-color_picker" name="admin_primary_color" class="form-control color_picker" data-control="wheel" value="{{getAdminColor()}}">
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Online status')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="checkbox" name="active" class="toogle-switch" value="1" {{(getSite()->active == 1) ? 'checked' : ''}}>
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Registration')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="checkbox" name="registration" class="toogle-switch" value="1" {{(getSite()->registration == 1) ? 'checked' : ''}}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="image-upload card border-light" style="min-height: 350px">
                        <div class="card-body">
                            <p>{{__('Image')}}</p>
                            <hr>
                            @php
                                $attachments_count = 1;
                                $image_source = (!empty(getSite()->logo)) ? asset_image(getSite()->logo) : null;
                            @endphp
                            @include('manage.partials._files-uploader')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div>
        {!! Form::open(['url' => route('todo.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        <input type="text" name="title">
        <button>submit</button>
        {!! Form::close() !!}

    </div>
</section>
<script>
    $('.color_picker').minicolors({
        control: 'wheel',
        theme: 'bootstrap'
    });
    $('.color_picker').change(function () {
        var input =  $(this);
        var new_color = input.val();
        input.val(new_color);
    });
</script>
@endsection
