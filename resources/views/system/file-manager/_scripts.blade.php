<script>



    @if(false)
    // dropzone settings
    Dropzone.options.dropzoneMediaFormOld = {
        // Setup chunking
        acceptedFiles: "video/*",
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