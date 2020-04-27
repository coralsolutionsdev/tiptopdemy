@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <!-- MiniColors -->
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($post)? __('main.Save changes') : __('main.submit')}}</span></button>
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
                    <p>{{__('main.Basic input')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('title',!empty($post) ? $post->title : null,['class' => 'form-control title','required' => true,'placeholder' => __('main.Title')]) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Content')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::textarea('content',!empty($post->content) ? $post->content : null,['class' => 'form-control content-editor', 'rows' => '15']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Tags')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::select('tags[]', $tags, $selectedTags, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'posts-tags', 'data-placeholder' => __('main.Create new tag'), 'style' => 'width:100%;']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('main.Properties')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Status')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($post) || !empty($post->status) ? 'checked' : null}}>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Allow Comments')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            <input type="checkbox" name="allow_comments_status" class="toogle-switch" value="1" {{empty($post) || !empty($post->allow_comments_status) ? 'checked' : null}}>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Approved Comment Status')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            <input type="checkbox" name="default_comment_status" class="toogle-switch" value="1" {{empty($post) || !empty($post->default_comment_status) ? 'checked' : null}}>
                        </div>
                    </div>

                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Category')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            {!! Form::select('categories',[null=> __('main.Please Select Category')] + $categories,!empty($selectedCategories) ? $selectedCategories : null,['class' => 'form-control']) !!}
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
        </div> <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('main.Attachments')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('main.Add attachment')}}</div>
                        <div class="col-lg-5" style="padding: 10px 0 10px 10px; margin: 0px">
                            <div class="custom-file">
                                <input type="file" name="attachments[]" multiple >
                            </div>
                        </div>
                    </div>

                    @if(!empty($attachments))
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">{{__('main.File name')}}</th>
                                <th scope="col">{{__('main.File Type')}}</th>
                                <th scope="col">{{__('main.Download link')}}</th>
                                <th scope="col" width="30">{{__('main.Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attachments as $attachment)
{{--                                {{dd($attachment)}}--}}
                                <tr>
                                    <td>{{$attachment->filename}}</td>
                                    <td>{{$attachment->filetype}}</td>
                                    <td><a target="_blank" href="{{$attachment->getTemporaryUrl(\Carbon\Carbon::parse(date('y-m-d'))->addDay())}}">Download</a></td>
                                    <td><span id="{{$attachment->key}}" class="btn btn-light btn-delete delete-attachment"><i class="far fa-trash-alt"></i></span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="attachment-message">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('main.Images')}}</p>
                    <hr>
                    <div class="row col-12">
                        <div class="col-lg-6 image-upload">
                            <p>{{__('main.Cover image')}}</p>
                            <div class="">
                                @php
                                    $attachments_count = 1;
                                    $image_source = (!empty($post) && !empty($post->image)) ? asset_image($post->image) : null;
                                @endphp
                                @include('manage.partials._files-uploader')
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="post-images" style="padding: 0px 20px">
                                <p>{{__('main.Images')}}</p>
                            @if(!empty($post) && !empty($post->images))
                                    @foreach($post->images as $id => $image)
                                        <div class="row d-flex align-items-center post-images-item"><div class="col-6"><img src="{{asset_image($image)}}" width="100" alt=""><input type="hidden" name="images[{{$id}}]" value="{{$image}}"></div><div class="col-6 d-flex justify-content-end"><span id="{{$id}}" class="btn btn-light btn-post-delete"><i class="far fa-trash-alt"></i></span></div></div>
                                    @endforeach
                                @endif

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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteAttachment()
        {
            $('.delete-attachment').click(function () {
                $('.attachment-message').html('<span class="text-warning"><i class="far fa-clock"></i> Deleting attachment .., Please wait</span>\n');
                var postId = '{{!empty($post->slug) ?  $post->slug : ''}}';
                var item = $(this);
                var key = item.attr('id');
                $.post('/manage/blog/post/'+postId+'/attachment/'+key+'/delete').done(function (response) {
                    item.parent().parent().remove();
                    $('.attachment-message').html('<span class="text-success"><i class="far fa-check-circle"></i> attachment deleted</span>\n');
                });
            });

        }
        deleteAttachment();
        function deleteImage()
        {
            $('.btn-post-delete').off('click');
            $('.btn-post-delete').click(function () {
                var item = $(this);
                item.parent().parent().remove();
            });
        }
        deleteImage();
        // generate random item code
        function generateRandomString(length) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < length; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
        var storeUrl =  '{{ route('blog.post.image.upload', array(), false) . '?_token=' . csrf_token() }}';

        tinymce.init({
            selector: '.content-editor',
            branding: false,
            menubar: true,
            statusbar: false,
            toolbar_drawer: 'sliding',
            // theme: "modern",
            fontsize_formats: "8pt 9pt 10pt 12pt 14pt 16pt 18pt 22pt 26pt 36pt 48pt 72pt",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor code fullscreen",
            ],
            toolbar1: "undo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect link| image media | forecolor backcolor | link unlink anchor | fontsizeselect forecolor backcolor  | print preview code fullscreen",
            relative_urls : false,
            remove_script_host : false,
            convert_urls : true,
            // content-editor
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', storeUrl);
                xhr.onload = function() {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.item.url != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    // add input
                    var imageId = generateRandomString(4);
                    $('#post-images').append('<div class="row d-flex align-items-center post-images-item"><div class="col-6"><img src="'+json.item.url+'" width="100" alt=""><input type="hidden" name="images['+imageId+']" value="'+json.item.path+'"></div><div class="col-6 d-flex justify-content-end"><span id="'+imageId+'" class="btn btn-light btn-post-delete"><i class="far fa-trash-alt"></i></span></div></div>');
                    deleteImage();
                    success(json.item.url);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);

            }

        });
    </script>
@endsection
