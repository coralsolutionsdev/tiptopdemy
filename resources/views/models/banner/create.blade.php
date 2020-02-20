@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Banners')
@section('head')
    <!-- MiniColors -->
    <script src="{{asset('plugins/color_picker/jquery.minicolors.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/color_picker/jquery.minicolors.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <style>
        .select2-container--default .select2-selection--multiple{
            border-radius: 2px !important;
            border: 1px solid #CED4DA;
        }
        .color-option{
            height: 22px;
            width: 22px;
            border-radius: 50%;
            border: 1px solid #566573;
        }
    </style>
@endsection

@section('content')
<section>
    @if(!empty($banner))
        {!! Form::open(['url' => route('banners.update', $banner->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @else
        {!! Form::open(['url' => route('banners.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @endif
    @include('manage.partials._page-header')
    <div class="form-panel row">
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Basic input')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('title',!empty($banner) ? $banner->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Link')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('link',!empty($banner) ? $banner->link : null,['class' => 'form-control slug','required' => false,'placeholder' => 'Link']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Content')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::textarea('content',!empty($banner->content) ? $banner->content : null,['class' => 'form-control content-editor', 'rows' => '15']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Tags')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            @php
                            $tags = array();
                            @endphp
{{--                            {!! Form::select('tags[]', $tags, $selectedTags, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'product-tags', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}--}}
                            {!! Form::select('tags[]', $tags, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'banner-tags', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Properties')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($banner) || !empty($banner->status) ? 'checked' : null}}>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Group')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            {!! Form::select('group',[null=>'-- Please select banner group --']+$banner_group,!empty($banner) ? $banner->group : null,['class' => 'form-control group-input']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Font Color')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            {!! Form::select('font_color',[null=>'-- Please Select font color --','light'=>'light','dark'=>'dark'],!empty($banner) ? $banner->font_color : null,['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Alignment')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            {!! Form::select('content_alignment',[null=>'-- Please Select content alignment --','right'=>'right','center'=>'center','left'=>'left'],!empty($banner) ? $banner->content_alignment : null,['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Background Color')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            <div class="row">
                                <div class="col-lg-5">
                                    <input type="text" id="wheel-color_picker" name="frontend_primary_color" class="form-control color_picker" data-control="wheel" value="" placeholder="Background primary color, ex: #FFFFFF">
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" id="wheel-color_picker" name="frontend_primary_color" class="form-control color_picker" data-control="wheel" value="" placeholder="Background secondary color, ex: #FFFFFF">
                                </div>
                                <div class="col-lg-2">
                                    <input type="number" class="form-control" value="0" step="45"  min="0" max="315" title="Color Gradients Angle">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12 padding-0 margin-0 icon-input" style="display: none">
                        <div class="col-lg-2 d-flex align-items-center padding-0">{{__('Icon')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            {!! Form::text('icon',!empty($banner) ? $banner->icon : null,['class' => 'form-control','placeholder' => 'Put the icon class']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Images')}}</p>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-5 image-upload">
                            <div class="">
                                @php
                                    $attachments_count = 1;
                                    $image_source = (!empty($banner) && !empty($banner->image)) ? asset_image($banner->image) : null;
                                @endphp
                                @include('manage.partials._files-uploader')
                            </div>
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
    <script>
        $('.group-input').change(function () {
            var group = $(this).val();
            if (group == 6){
                $('.icon-input').slideDown();
                console.log('yes');
            }else {
                $('.icon-input').slideUp();

            }
        });
        $('.color_picker').minicolors({
            control: 'wheel',
            theme: 'bootstrap'
        });
        $('.color_picker').change(function () {
            var input =  $(this);
            var new_color = input.val();
            input.val(new_color);
        });
        $("#banner-tags").select2({
            tags:true, // change to false to disable add new tags
        });
    </script>
@endsection
