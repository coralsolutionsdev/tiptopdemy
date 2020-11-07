<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    {{--$('.uploader-input').change(function (){--}}
    {{--    var file_names = $.map($(this).prop('files'), function(file)--}}
    {{--    {--}}
    {{--        return file.name;--}}
    {{--    });--}}
    {{--    var file_section = $('.uploader-items');--}}
    {{--    file_section.html('');--}}
    {{--    file_names.map(function(file_name)--}}
    {{--    {--}}
    {{--        file_section.append('<span><span uk-icon="icon: play-circle"></span> '+file_name+'</span>');--}}
    {{--    });--}}
    {{--});--}}

    function resetProgressBar(){
        // var bar = $('#js-progressbar');
        // bar.attr('value', 0)

    }
    {{--function resetUploadForm($resetType = true)--}}
    {{--{--}}
    {{--    $('#insertMediaModalForm').get(0).reset();--}}
    {{--    if ($resetType ==  true){--}}
    {{--        $("[name='type']").val({{\App\Modules\Media\Media::TYPE_YOUTUBE}});--}}
    {{--    }--}}
    {{--    $('.uploader-items').html('');--}}
    {{--}--}}
    {{--function resetInsertMediaModal()--}}
    {{--{--}}
    {{--    resetUploadForm();--}}
    {{--    resetProgressBar();--}}
    {{--    $('.process-icon').html('')--}}
    {{--    $('.process-status').html('');--}}

    {{--    UIkit.tab('.media-tabs').show(0);--}}
    {{--}--}}
    {{--$('.open-insert-media-modal').click(function (){--}}
    {{--    resetInsertMediaModal();--}}
    {{--});--}}

    {{--$('.media-tab-item').click(function (){--}}
    {{--    var btn = $(this);--}}
    {{--    var type = btn.attr('data-value');--}}
    {{--    resetInsertMediaModal();--}}
    {{--    resetUploadForm();--}}
    {{--    // $("[name='type']").val(type);--}}
    {{--});--}}

    /**
     * Attach medoa to lesson
     *
     */
    function drawMediaItem(media)
    {
        var data = {
            'name': media.name,
            'path': media.path,
            'mime_type': media.mime_type,
            'file_type': media.file_type,
            'extension': media.extension,
            'duration': media.duration,
        };
        $.post('{{route('store.add.resources.item', $lesson->slug)}}',data).done(function (response) {
            var media = response;
            var type = media.type;
            var url = media.url;
            var id = media.id;
            var video = null;
            // insert media
            if (type == {{\App\Modules\Media\Media::TYPE_VIDEO}}){
                video = '<video src="'+url+'" muted playsinline controls disablepictureinpicture controlsList="nodownload"></video>';
            } else if (type == {{\App\Modules\Media\Media::TYPE_YOUTUBE}} || type == {{\App\Modules\Media\Media::TYPE_HTML_PAGE}}){
                video = '<iframe src="'+url+'" class="uk-responsive-width" width="1920" height="1080" controls controlsList="nodownload" frameborder="0" uk-responsive></iframe>';
            }
            $('.resource-items-list').append('' +
                '<li id="resource-'+id+'" class="resource-item" style="overflow: hidden">\n' +
                '    <div class="uk-card uk-card-default uk-card-body uk-padding-remove">\n' +
                '        <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger resource-delete" uk-icon="icon: trash"></span></div>\n' +
                '        <div>\n' +
                '           <input type="hidden" name="resourceId[]" value="'+id+'">\n' +
                '            '+video+'\n' +
                '        </div>\n' +
                '    </div>\n' +
                '</li>');

                UIkit.notification("<span uk-icon='icon: check'></span> "+ response.message, {pos: 'top-center', status:'success'})
                $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                $('.process-status').html('<span class="uk-text-success"> Completed: 100%</span>');
        });

    }


    Dropzone.options.dropzoneForm = {
        // Setup chunking
        acceptedFiles: "video/*",
        maxFiles: 1,
        timeout: 3600000,
        autoProcessQueue: false,
        chunking: true,
        maxFilesize: 400000000,
        chunkSize: 1000000,
        // If true, the individual chunks of a file are being uploaded simultaneously.
        parallelChunkUploads: false,
        init: function() {
            // stop auto upload
            var submitBtn = $('#dropZoneStartUpload');
            var cancelBtn = $('#dropZoneCancelUpload');
            var myDropZone = this;
            submitBtn.click(function (){
                if (myDropZone.files && myDropZone.files.length > 0){
                    $('.process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.6"></div></span>')
                    myDropZone.processQueue();
                    submitBtn.attr('disabled', true);
                    submitBtn.html("{{__('main.Uploading')}}");
                    cancelBtn.show();
                } else {
                    UIkit.notification("<span uk-icon='icon: check'></span> Please select a file to upload first.", {pos: 'top-center', status:'warning'})
                }
            });
            cancelBtn.click(function (){
                myDropZone.removeAllFiles(true);
                $('.process-icon').html('<span class="uk-text-warning"><span uk-icon="icon: warning"></span></span>')
                $('.process-status').html('<span class="uk-text-warning"> Uploading canceled</span>');
                cancelBtn.hide();
                submitBtn.attr('disabled', false);
                submitBtn.html("{{__('main.Start upload')}}");
            });
            this.on("addedfile", function(file) {
                // alert("Added file.");
            });
            this.on("complete", function(file) {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){
                var _this = this;
                    _this.removeAllFiles();
                }
                if (file.xhr.response){
                    var media = JSON.parse(file.xhr.response);
                    // console.log(media, media.path);
                    submitBtn.attr('disabled', false);
                    submitBtn.html("{{__('main.Start upload')}}");
                    cancelBtn.hide();
                    // $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                    $('.process-status').html('<span class="uk-text-success"> Processing: 99.9%</span>');
                    drawMediaItem(media);

                }
            });
            this.on("uploadprogress", function(file, progress, bytesSent) {
                progress = bytesSent / file.size * 100;
                $('.dz-upload').width(progress + "%");
                if (progress < 100){
                    $('.process-status').html('<span class="uk-text-primary"> Uploading: '+progress.toFixed(1)+'%</span>');
                }
            });
        }
    }
    @if(false)

    Dropzone.autoDiscover = false;


    $(document).ready(function() {


    });
{{--    @if(!empty($lesson))--}}
    $('.attach-media').click(function (){
        var btn = $(this);
        var bar = $('#js-progressbar');
        $('#js-progressbar').attr('value',0).hide();
        var form = $('#insertMediaModalForm')[0];
        var data = new FormData(form);
        var files = $('#upload_file')[0].files;
        if(files.length > 0 ){
            data.append('file',files[0]);
        }
        var itemId = "{{$lesson->id}}";
        var modelType = "{{addslashes($lesson->getClassName())}}";
        data.append('item_id',itemId);
        data.append('model_type',modelType);
       $('.process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.5"></div></span>')
        btn.attr('disabled', true);
        btn.html("{{__('main.Uploading')}}");
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "{{route('store.media.attach')}}",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            // xhr: function() {
            //     var xhr = new window.XMLHttpRequest();
            //     xhr.upload.addEventListener("progress", function(evt) {
            //         if (evt.lengthComputable) {
            //             var percentComplete = (evt.loaded / evt.total) * 100;
            //             var currentPercentage = percentComplete.toFixed(1);
            //             //Do something with upload progress here
            //             bar.show();
            //             bar.attr('value', percentComplete);
            //             if (percentComplete == 100){
            //                 currentPercentage = parseInt(percentComplete);
            //                 $('.process-status').html('<span class="uk-text-primary"> Processing: '+currentPercentage+'%</span>');
            //             }else {
            //                 $('.process-status').html('<span class="uk-text-primary"> Uploading: '+currentPercentage+'%</span>');
            //             }
            //
            //         }
            //     }, false);
            //     return xhr;
            // },
            complete: function (response){
                console.log(response)
                    if (response.responseJSON != undefined){
                        var resource = response.responseJSON;
                        var status = resource.status;
                        var type = resource.type;
                        var url = resource.url;
                        var id = resource.id;
                        var video = null;

                        if (status == {{\App\Modules\Media\Media::UPLOAD_TYPE_REFUSED}}){
                            resetProgressBar();
                            $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: ban"></span></span>')
                            $('.process-status').html('<span class="uk-text-danger"> Canceled: 0%</span>');
                            UIkit.notification("<span uk-icon='icon: warning'></span> "+ resource.message, {pos: 'top-center', status:'warning'})
                        } else if(status = {{\App\Modules\Media\Media::UPLOAD_TYPE_COMPLETED}}){
                            UIkit.notification("<span uk-icon='icon: check'></span> "+ resource.message, {pos: 'top-center', status:'success'})
                            // insert media
                            if (type == {{\App\Modules\Media\Media::TYPE_VIDEO}}){
                                video = '<video src="'+url+'" muted playsinline controls disablepictureinpicture controlsList="nodownload"></video>';
                            } else if (type == {{\App\Modules\Media\Media::TYPE_YOUTUBE}} || type == {{\App\Modules\Media\Media::TYPE_HTML_PAGE}}){
                                video = '<iframe src="'+url+'" class="uk-responsive-width" width="1920" height="1080" controls controlsList="nodownload" frameborder="0" uk-responsive></iframe>';
                            }
                            $('.resource-items-list').append('' +
                                '<li id="resource-'+id+'" class="resource-item" style="overflow: hidden">\n' +
                                '    <div class="uk-card uk-card-default uk-card-body uk-padding-remove">\n' +
                                '        <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger resource-delete" uk-icon="icon: trash"></span></div>\n' +
                                '        <div>\n' +
                                '           <input type="hidden" name="resourceId[]" value="'+id+'">\n' +
                                '            '+video+'\n' +
                                '        </div>\n' +
                                '    </div>\n' +
                                '</li>');
                            deleteResourceItem();
                            $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                            $('.process-status').html('<span class="uk-text-success"> Completed: 100%</span>');

                        }
                        resetUploadForm(false);
                        btn.attr('disabled', false);
                        btn.html("{{__('main.Start upload')}}");
                    }
            },
            error: function (e) {
                resetProgressBar();
                console.log(e);
                UIkit.notification("<span uk-icon='icon: warning'></span> "+ e.statusText, {pos: 'top-center', status:'danger'})
                resetUploadForm();
                $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: ban"></span></span>')
                $('.process-status').html('<span class="uk-text-danger"> Canceled: 0%</span>');
                btn.attr('disabled', false);
                btn.html("{{__('main.Start upload')}}");
            }
        });
    });
    @endif
    function deleteResourceItem(){
        $('.resource-delete').click(function (){
            var btn = $(this);
            var resource =  btn.closest('.resource-item');
            var resourceId =  resource.attr('id').split('-')[1];
            if (!confirm("Are you sure that you want to delete this item?")){
                return false;
            }
            resource.remove();
            $('.removed-resources-items').append('<input type="hidden" name="removed-resources[]" value="'+resourceId+'">');
        });
    }
    deleteResourceItem();
</script>