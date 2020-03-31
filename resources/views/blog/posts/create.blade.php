@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
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
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
<section>
@if(!empty($post))
    {!! Form::open(['url' => route('posts.update', $post->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
@else
    {!! Form::open(['url' => route('posts.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
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
                            {!! Form::text('title',!empty($post) ? $post->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Slug title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('slug',!empty($post) ? $post->slug : null,['class' => 'form-control slug','required' => true,'placeholder' => 'slug-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Content')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::textarea('content',!empty($post->content) ? $post->content : null,['class' => 'form-control content-editor', 'rows' => '15']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Tags')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            @php
                                $tags = array();
                            @endphp
                            {{--                            {!! Form::select('tags[]', $tags, $selectedTags, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'product-tags', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}--}}
                            {!! Form::select('tags[]', $tags, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'posts-tags', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
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
                            <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($post) || !empty($post->status) ? 'checked' : null}}>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Category')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            {!! Form::select('categories',[null=>'-- Please Select Category --'] + $categories,!empty($selectedCategories) ? $selectedCategories : null,['class' => 'form-control']) !!}
{{--                            <div>--}}
{{--                                <span class="btn btn-primary" data-toggle="collapse" data-target="#demo">Show list of categories</span>--}}
{{--                                <div id="demo" class="collapse">--}}
{{--                                    {{drawInputTreeListItems($tree_categories, 'categories[]',!empty($selectedCategories) ? $selectedCategories : array(), 'checktree')}}--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
                                    $image_source = (!empty($post) && !empty($post->image)) ? asset_image($post->image) : null;
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
        var title = $('.title');
        var slug = $('.slug');
        title.on('input', function(){
            var slag_input = $(this).val().replace(/ /g,"-").replace('?',"-").replace('!',"-").replace('.',"-").toLowerCase();
            slug.val(slag_input);
        });
        $("#posts-tags").select2({
            tags:true, // change to false to disable add new tags
        });
    </script>
@endsection
