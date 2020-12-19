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
                    <a class="uk-button uk-button-primary uk-width-expand open-media-uploader-modal" href="#mediaUploaderModal" uk-toggle><span uk-icon="icon: plus"></span> Add File</a>
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
                            <h5>All Files</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-items" uk-grid="masonry: true">
                                <div class="uk-flex uk-flex-center uk-text-center uk-width-1-1">
                                    <div>
                                        <div class="uk-margin">
                                            <span class="uk-text-primary" uk-spinner="ratio: 2"></span>
                                        </div>
                                        Media items are loading ..
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <h5>All Images</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-image-items" uk-grid="masonry: true">
                                <div class="uk-flex uk-flex-center uk-text-center uk-width-1-1">
                                    <div>
                                        <div class="uk-margin">
                                            <span class="uk-text-primary" uk-spinner="ratio: 2"></span>
                                        </div>
                                        Media items are loading ..
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <h5>All Videos</h5>
                            <div class="uk-grid-small uk-child-width-1-4@s file-manager-video-items" uk-grid="masonry: true">
                                <div class="uk-flex uk-flex-center uk-text-center uk-width-1-1">
                                    <div>
                                        <div class="uk-margin">
                                            <span class="uk-text-primary" uk-spinner="ratio: 2"></span>
                                        </div>
                                        Media items are loading ..
                                    </div>
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






    <script>

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function copyToClipboard(text) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(text).select();
                document.execCommand("copy");
                $temp.remove();
            }

            function openMediaItemCanvas(){
                $('.media-item').off('click').click(function (){
                    var item = $(this);
                    var type = item.attr('type-value');
                    $('.media-item-preview').html('');
                    if (type == 'image'){
                        $('.media-item-preview').html('<img data-src="'+item.attr('url-value')+'" width="1800" height="1200" alt="" uk-img>');
                    }else if(type == 'video'){
                        $('.media-item-preview').html('<video src="'+item.attr('url-value')+'" playsinline controls disablepictureinpicture controlsList="nodownload"></video>');
                    }else if(type == 'audio'){
                        $('.media-item-preview').html(`<audio controls controlsList="nodownload">
                        <source class="audio-source" src="`+item.attr('url-value')+`" type="audio/mpeg">
                    </audio>`);
                    }
                    $('.media-item-name').html(item.attr('name-value'));
                    $('.media-item-extension').html(item.attr('extension-value'));
                    $('.media-item-size').html(item.attr('size-value'));
                    $('.media-item-creation').html(item.attr('creation-value'));
                    $('.copy-url-btn').attr('id', 'copyUrlItem-'+item.attr('id-value'));
                    $('.delete-media-item').attr('id', 'deleteMediaItem-'+item.attr('id-value'));
                    UIkit.offcanvas('#mediaItemOffCanvas').show();
                });

            }
            function copyMediaUrl()
            {
                $('.copy-url-btn').off('click').click(function (){
                    var btn = $(this);
                    var btnId = btn.attr('id').split('-')[1];
                    var item = $('#mediaItem-'+btnId);
                    var url = item.attr('url-value');
                    copyToClipboard(url);
                    UIkit.notification("<span uk-icon='icon: check'></span> Media url copied to clipboard.", {pos: 'top-center', status:'success'})

                });
            }

            function deleteMediaItem()
            {
                $('.delete-media-item').off('click').click(function (){
                    var btn = $(this);
                    var btnId = btn.attr('id').split('-')[1];
                    UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to delete this media item?').then(function() {

                        $.post('/manage/media/ajax/delete/'+btnId).done(function (response){
                            $('#mediaItem-'+btnId).remove();
                            console.log(response)
                        });

                    }, function () {
                        console.log('Rejected.')
                    });
                });
            }

            function drawMediaItem(item)
            {
                var imageUrl = '{{asset_image('assets/file_icons/')}}'+'/'+item.extension+'.png';
                var prevTag = '<div class="uk-padding"><img data-src="'+imageUrl+'" width="50" height="" alt="" uk-img></div>'
                if (item.file_type == "image"){
                    imageUrl = item.url;
                    prevTag = '<img data-src="'+imageUrl+'" sizes="(min-width: 650px) 650px, 100vw"  height="" alt="" uk-img>'
                }
                $('.file-manager-items').prepend(`
                   <div id="mediaItem-`+item.id+`" class="media-item" id-value="`+item.id+`" name-value="`+item.name+`" extension-value="`+item.extension+`" size-value="`+item.file_size_string+`" creation-value="`+item.creation_date+`" url-value="`+item.url+`" type-value="`+item.file_type+`">
                      <div class="bg-white" style="border: 1px solid #DFE3E7;">
                          <div class="uk-text-center" style="background-color: #F2F4F4">
                              `+prevTag+`
                          </div>
                          <div class="uk-padding-small">
                            <p class="uk-margin-remove">`+item.name+`.`+item.extension+`</p>
                            <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">`+item.file_size_string+`</p>
                            <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">`+item.creation_date+`</p>
                          </div>
                      </div>
                  </div>`);
                $('.file-manager-'+item.file_type+'-items').prepend(`
                   <div id="mediaItem-`+item.id+`" class="media-item" id-value="`+item.id+`" name-value="`+item.name+`" extension-value="`+item.extension+`" size-value="`+item.file_size_string+`" creation-value="`+item.creation_date+`" url-value="`+item.url+`" type-value="`+item.file_type+`">
                      <div class="bg-white" style="border: 1px solid #DFE3E7;">
                          <div class="uk-text-center" style="background-color: #F2F4F4">
                              `+prevTag+`
                          </div>
                          <div class="uk-padding-small">
                            <p class="uk-margin-remove">`+item.name+`.`+item.extension+`</p>
                            <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">`+item.file_size_string+`</p>
                            <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">`+item.creation_date+`</p>
                          </div>
                      </div>
                  </div>`);
                openMediaItemCanvas();
                copyMediaUrl();
                deleteMediaItem();
            }

            Dropzone.options.dropzoneForm = {
                // Setup chunking
                acceptedFiles: "image/*,video/*,audio/*",
                maxFiles: 5,
                timeout: 3600000,
                autoProcessQueue: true,
                chunking: true,
                maxFilesize: 400000000,
                chunkSize: 1000000,
                // If true, the individual chunks of a file are being uploaded simultaneously.
                parallelChunkUploads: false,
                init: function() {

                    var myDropZone = this;

                    var cancelBtn = $('#dropZoneCancelUpload');
                    $('.open-media-uploader-modal').click(function (){
                        if (myDropZone.files && myDropZone.files.length < 1){
                            $('.process-icon').html('')
                            $('.process-status').html('');
                        }
                    });
                    // cancel uploading
                    cancelBtn.click(function (){
                        myDropZone.removeAllFiles(true);
                        $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: minus-circle"></span></span>')
                        $('.process-status').html('<span class="uk-text-danger"> Uploading canceled</span>');
                        cancelBtn.hide();
                    });

                    this.on("addedfile", function(file) {
                        // alert("Added file.");
                        cancelBtn.show();
                        $('.process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.6"></div></span>')
                    });
                    this.on("uploadprogress", function(file, progress, bytesSent) {
                        progress = bytesSent / file.size * 100;
                        $('.dz-upload').width(progress + "%");
                        if (progress > 99.9){
                            progress = 100
                        }
                        if (progress < 99.9){
                            $('.process-status').html('<span class="uk-text-success"> Processing: (Please keep this window opened)</span>');
                        }
                        $('.process-status').html('<span class="uk-text-primary"> Uploading: '+progress.toFixed(1)+'%</span>');
                    });
                    this.on("complete", function(file) {
                        if (file.xhr.response){
                            var item = JSON.parse(file.xhr.response)
                            drawMediaItem(item);
                        }


                        {{--if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){--}}
                        {{--    var _this = this;--}}
                        {{--    _this.removeAllFiles();--}}
                        {{--}--}}
                        {{--if (file.xhr.response){--}}
                        {{--    var media = JSON.parse(file.xhr.response);--}}
                        {{--    // console.log(media, media.path);--}}
                        {{--    submitBtn.attr('disabled', false);--}}
                        {{--    submitBtn.html("{{__('main.Start upload')}}");--}}
                        {{--    cancelBtn.hide();--}}
                        {{--    // $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')--}}
                        {{--    $('.process-status').html('<span class="uk-text-success"> Processing: (Please keep this window opened)</span>');--}}
                        {{--    drawMediaItem(media);--}}

                        {{--}--}}
                    });
                    this.on("success", function(event) {
                        if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){
                            var _this = this;
                            setTimeout(
                                function()
                                {
                                    _this.removeAllFiles();
                                }, 1500);
                        }
                        cancelBtn.hide();
                        $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                        $('.process-status').html('<span class="uk-text-success"> Completed: 100%</span>');
                        UIkit.notification("<span uk-icon='icon: check'></span> Uploading status: "+ event.status, {pos: 'top-center', status:'success'})

                    });
                    this.on("error", function(event) {
                        {{--console.log(event);--}}
                        {{--UIkit.notification("<span uk-icon='icon: warning'></span> " +event.status, {pos: 'top-center', status:'danger'});--}}
                        {{--submitBtn.html("{{__('main.Start upload')}}");--}}
                        {{--cancelBtn.hide();--}}
                        {{--submitBtn.attr('disabled', false);--}}
                        {{--submitBtn.html("{{__('main.Start upload')}}");--}}
                    });
                }
            }

            $.get('{{ route('media.get.library.items')}}')
                .done(function (response) {
                    $('.file-manager-items').html('');
                    $('.file-manager-image-items').html('');
                    $('.file-manager-video-items').html('');
                    response.map(function (media){
                        var item = {
                            id:media.id,
                            name:media.name,
                            url:media.url,
                            file_type:media.custom_properties.file_type,
                            file_size_string:media.custom_properties.file_size_string,
                            extension:media.custom_properties.extension,
                            creation_date:media.creation_date,
                        }
                        drawMediaItem(item);
                    });
                });

    </script>

@endsection
