<script>
        /**
         * js initials
         */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        @if(!empty($lesson))
        // functions
        function resetMediaModal(resetStatus = false){
            $("input[name=embed_url]").val("");
            $("select[name=media_type]").val({{\App\Modules\Media\Media::TYPE_YOUTUBE}})
            $("input[name=embed_url]").removeClass('uk-form-danger');
            if (resetStatus == true){
                $('.process-icon').html('')
                $('.process-status').html('');
            }
        }
        // delete media item
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
        /*
         * Attach media to lesson
         */
        function drawMediaItem(media)
        {
            var resourceBtn = $('#resourceStartUpload');
            resourceBtn.attr('disabled', true);
            resourceBtn.html("{{__('main.Uploading')}}");
            $('.process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.6"></div></span>')
            $('.process-status').html('<span class="uk-text-success"> Processing: (Please keep this window opened)</span>');
            $.post('{{route('store.add.resources.item', $lesson->slug)}}',media).done(function (response) {
                var media = response;
                var status = media.status;
                var type = media.type;
                var url = media.url;
                var id = media.id;
                var video = null;
                if (status == {{\App\Modules\Media\Media::UPLOAD_TYPE_COMPLETED}}){
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
                    UIkit.notification("<span uk-icon='icon: check'></span> "+ response.message, {pos: 'top-center', status:'success'})
                    $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                    $('.process-status').html('<span class="uk-text-success"> Completed: 100%</span>');
                    resourceBtn.attr('disabled', false);
                    resourceBtn.html("{{__('main.Start upload')}}");
                    resetMediaModal();
                } else if (status == {{\App\Modules\Media\Media::UPLOAD_TYPE_REFUSED}}){
                    // error
                    UIkit.notification("<span uk-icon='icon: warning'></span> Oops! something went wrong!", {pos: 'top-center', status:'danger'});
                    $('.process-icon').html('<span class="uk-text-warning"><span uk-icon="icon: warning"></span></span>')
                    $('.process-status').html('<span class="uk-text-warning"> Uploading canceled</span>');
                }

            });

        }
        // reset media modal
        $('.media-tab-item, .open-insert-media-modal').click(function (){
            resetMediaModal(true)
        });
        // resource start upload
        $('#resourceStartUpload').click(function (){

            var path = $("input[name=embed_url]").val();

            var submitBtn = $('#resourceStartUpload');
            submitBtn.attr('disabled', false);
            submitBtn.html("{{__('main.Start upload')}}");

            if (path == ''){
                UIkit.notification("<span uk-icon='icon: minus-circle'></span> Please add an embed link first", {pos: 'top-center', status:'danger'});
                $("input[name=embed_url]").addClass('uk-form-danger');
                return false;
            }

            var mediaType = $("select[name=media_type]").val()
            var media = {
                'name': 'Untitled',
                'path': path,
                'mime_type': '',
                'file_type': '',
                'media_type': mediaType,
                'extension': '',
                'duration': '',
            };
            drawMediaItem(media);
        });
        // dropzone settings
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
                        UIkit.notification("<span uk-icon='icon: warning'></span> Please select a file to upload first.", {pos: 'top-center', status:'warning'})
                    }
                });
                cancelBtn.click(function (){
                    myDropZone.removeAllFiles(true);
                    $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: minus-circle"></span></span>')
                    $('.process-status').html('<span class="uk-text-danger"> Uploading canceled</span>');
                    cancelBtn.hide();
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
                        $('.process-status').html('<span class="uk-text-success"> Processing: (Please keep this window opened)</span>');
                        drawMediaItem(media);

                    }
                });
                this.on("uploadprogress", function(file, progress, bytesSent) {
                    progress = bytesSent / file.size * 100;
                    $('.dz-upload').width(progress + "%");
                    if (progress < 99.9){
                        $('.process-status').html('<span class="uk-text-primary"> Uploading: '+progress.toFixed(1)+'%</span>');
                    }
                });
                this.on("error", function(event) {
                    console.log(event);
                    UIkit.notification("<span uk-icon='icon: warning'></span> " +event.status, {pos: 'top-center', status:'danger'});
                    submitBtn.html("{{__('main.Start upload')}}");
                    cancelBtn.hide();
                    submitBtn.attr('disabled', false);
                    submitBtn.html("{{__('main.Start upload')}}");
                });
            }
        }
        @endif


</script>