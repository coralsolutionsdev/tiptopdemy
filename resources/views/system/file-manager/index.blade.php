@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
@endsection
@section('head')
    <style>
        html,body{
            /*height: 100vh;*/
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('plugins/dropzone/dropzone.css')}}">
    <script src="{{asset('/plugins/dropzone/dropzone.js')}}"></script>
@endsection
@section('content')

    <div style="border: 1px solid #DFE3E7; min-height: 90vh">
        <div class="uk-grid-collapse" uk-grid >
            <div class="uk-width-1-5@m uk-height-large">
                <div style="padding: 25px">


                    <div class="">
                        <button class="uk-button uk-button-primary uk-width-expand" type="button"><span uk-icon="icon: plus"></span> Add New</button>
                        <div uk-dropdown="mode: click">
                            <ul class="uk-nav uk-dropdown-nav">
                                <li><a class="open-media-uploader-modal" href="#mediaUploaderModal" uk-toggle><span uk-icon="icon: file"></span> New File</a></li>
                                <li><a class="open-media-folder-modal" href="#mediaGroupModal" uk-toggle><span uk-icon="icon: folder"></span> New Folder</a></li>
{{--                                <li class="uk-nav-header">Header</li>--}}
{{--                                <li><a href="#">Item</a></li>--}}
{{--                                <li><a href="#">Item</a></li>--}}
{{--                                <li class="uk-nav-divider"></li>--}}
{{--                                <li><a href="#">Item</a></li>--}}
                            </ul>
                        </div>
                    </div>



                </div>
                <div class="uk-margin-small-top" style="padding: 0 25px">
                    <p class="uk-text-muted">My Files</p>
                </div>
                <div>
                    <ul class="uk-tab-right" uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                        <li>
                            <a href="" class="" style="padding: 10px">
                                <div class="uk-grid-collapse uk-grid-match uk-flex uk-flex-middle" uk-grid>
                                    <div class="uk-width-1-6 uk-text-center ">
                                        <span uk-icon="icon: thumbnails; ratio: 1.3"></span>
                                    </div>
                                    <div class="uk-width-expand uk-flex uk-flex-middle">
                                        All Files
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="" style="padding: 10px">
                                <div class="uk-grid-collapse uk-grid-match uk-flex uk-flex-middle" uk-grid>
                                    <div class="uk-width-1-6 uk-text-center ">
                                        <span uk-icon="icon: image"></span>
                                    </div>
                                    <div class="uk-width-expand uk-flex uk-flex-middle">
                                        Images
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="" style="padding: 10px">
                                <div class="uk-grid-collapse uk-grid-match uk-flex uk-flex-middle" uk-grid>
                                    <div class="uk-width-1-6 uk-text-center ">
                                        <span uk-icon="icon: play-circle; ratio: 1.1"></span>
                                    </div>
                                    <div class="uk-width-expand uk-flex uk-flex-middle">
                                        Video
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-expand@m">
                <div class="bg-white" style="border-left: 1px solid #DFE3E7; padding: 25px; min-height: 400px">
                    <ul id="component-tab-left" class="uk-switcher">
                        <li>
                            <h5>All Folders</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-folders" uk-grid="masonry: true">
{{--                                <div>--}}
{{--                                    <div class="uk-grid-collapse uk-padding-small" uk-grid style="background-color: #F2F4F4; border: 1px #DFE3E7;">--}}
{{--                                        <div class="uk-width-1-3">--}}
{{--                                            <img data-src="{{asset_image('assets/file_icons/folder.png')}}" width="50" height="" alt="" uk-img>--}}
{{--                                        </div>--}}
{{--                                        <div class="uk-width-2-3 uk-flex uk-flex-middle">--}}
{{--                                            <div>--}}
{{--                                                <p class="uk-margin-remove">Folder name</p>--}}
{{--                                                <p class="uk-margin-remove uk-text-muted">4 Fiels</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            </div>
                            <hr>
                            <h5>All Files</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-items" uk-grid="masonry: true">
                                <div class="uk-flex uk-flex-center uk-text-center uk-width-1-1">

                                </div>
                            </div>
                        </li>
                        <li>
                            <h5>All Images</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-image-items" uk-grid="masonry: true">
                                <div class="uk-flex uk-flex-center uk-text-center uk-width-1-1">

                                </div>
                            </div>
                        </li>
                        <li>
                            <h5>All Videos</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-video-items" uk-grid="masonry: true">
                                <div class="uk-flex uk-flex-center uk-text-center uk-width-1-1">

                                </div>
                            </div>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </div>
    @if(false)
        <div>
            <div class="bg-white" style="border: 1px solid #DFE3E7;">
                <div class="uk-padding uk-text-center" style="background-color: #F2F4F4">
                    <img data-src="{{asset_image('assets/file_icons/jpg.png')}}" width="50" height="" alt="" uk-img>
                </div>
                <div class="uk-padding-small">
                    <p class="uk-margin-remove">Image name</p>
                    <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">image size</p>
                    <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">creation date</p>
                </div>
            </div>
        </div>
    @endif

    <div id="mediaItemOffCanvas" class="uk-light light-offcanvas" uk-offcanvas="flip: true">
        <div class="uk-offcanvas-bar" style="background-color: #1E1E2D">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div class="uk-margin-small">
                <div class="media-item-preview uk-width-expand">

                </div>
                <hr>
                <div class="media-item-details">
                <p class="uk-text-muted">File info</p>
                    <div class="uk-grid-collapse" uk-grid>
                        <div class="uk-width-1-3">File name:</div><div class="uk-width-2-3 uk-text-right media-item-name">my_image.jpg</div>
                        <div class="uk-width-1-3">Format:</div><div class="uk-width-2-3 uk-text-right media-item-extension">my_image.jpg</div>
                        <div class="uk-width-1-3">Size:</div><div class="uk-width-2-3 uk-text-right media-item-size">my_image.jpg</div>
                        <div class="uk-width-1-3">Creation date:</div><div class="uk-width-2-3 uk-text-right media-item-creation">my_image.jpg</div>
                    </div>
                    <hr>
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-1-2"><button class="uk-button uk-button-default uk-width-1-1 copy-url-btn" id="">Copy link</button></div><div class="uk-width-1-2 uk-text-right"><button class="uk-button uk-button-danger uk-width-1-1 delete-media-item">Delete</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mediaUploaderModal" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h5>File uploader</h5>
            </div>
            <div class="uk-modal-body">
                <div class="uk-placeholder">
                    <form id="dropzoneForm" action="{{route('media.store')}}" class="dropzone uk-width-1-1 uk-flex uk-flex-center" id="myAwesomeDropzone" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <div class="" style="padding: 0px">
                    <div class="uk-grid-collapse" uk-grid>
                        <div class="uk-width-expand">
                            <span class="process-icon"></span> <span class="process-status"></span>
                        </div>
                        <div class="uk-width-auto">
                            <button id="dropZoneCancelUpload" class="uk-button uk-button-danger" type="button" style="display: none">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
{{--                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>--}}
{{--                <button class="uk-button uk-button-primary" type="button">Save</button>--}}
            </div>
        </div>
    </div>

    <div id="mediaGroupModal" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h5>New Folder</h5>
            </div>
            <div class="uk-modal-body">
                <div class="uk-margin">
{{--                    {!! Form::open(['url' => route('system.group.ajax.create'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}--}}

                    <label class="uk-form-label" for="form-stacked-text">Title</label>
                    <div class="uk-form-controls">
                        <input class="uk-input group-title" type="text" name="title" placeholder="Folder title">
                    </div>
{{--                    <button>submit</button>--}}
{{--                    {!! Form::close() !!}--}}
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-expand uk-text-left uk-flex uk-flex-middle">
                        <span class="group-process-icon"></span> <span class="group-process-status"></span>
                    </div>
                    <div class="uk-width-auto uk-text-right">
                        <button class="uk-button uk-button-primary create-media-group" type="button">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>






@include('system.file-manager._scripts')

@endsection
