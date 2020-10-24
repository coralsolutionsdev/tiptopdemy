<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.uploader-input').change(function (){
        var file_names = $.map($(this).prop('files'), function(file)
        {
            return file.name;
        });
        var file_section = $('.uploader-items');
        file_section.html('');
        file_names.map(function(file_name)
        {
            file_section.append('<span><span uk-icon="icon: play-circle"></span> '+file_name+'</span>');
        });
    });

    function resetProgressBar(){
        var bar = $('#js-progressbar');
        bar.attr('value', 0)

    }
    function resetUploadForm($resetType = true)
    {
        $('#insertMediaModalForm').get(0).reset();
        if ($resetType ==  true){
            $("[name='type']").val({{\App\Modules\Media\Media::TYPE_VIDEO}});
        }
        $('.uploader-items').html('');
    }
    function resetInsertMediaModal()
    {
        resetUploadForm();
        resetProgressBar();
        $('.process-word').html("");
        $('.process-percentage').html("");
        UIkit.tab('.media-tabs').show(0);
    }
    $('.open-insert-media-modal').click(function (){
        resetInsertMediaModal();
    });

    $('.media-tab-item').click(function (){
        var btn = $(this);
        var type = btn.attr('data-value');
        resetInsertMediaModal();
        $("[name='type']").val(type);
    });


    $('.attach-media').click(function (){
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
        var processStatus = $('.process-status');
        processStatus.find('.process-word').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.5"></div> Uploading:</span>')
        processStatus.find('.process-percentage').html('<span class="uk-text-primary">0%</span>')

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "{{route('store.media.attach')}}",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        //Do something with upload progress here
                        bar.show();
                        bar.attr('value', percentComplete);
                        $('.process-percentage').html('<span class="uk-text-primary">'+parseInt(percentComplete)+'%</span>')

                    }
                }, false);
                return xhr;
            },
            complete: function (response){
                var media = response.responseJSON.media;
                var status = media.status;
                var type = media.type;
                var url = media.url;
                var id = media.id;
                var video = null;

                if (status == {{\App\Modules\Media\Media::UPLOAD_TYPE_REFUSED}}){
                    resetProgressBar();
                    processStatus.find('.process-percentage').html('<span class="">0%</span>')
                    processStatus.find('.process-word').html('<span class="uk-text-danger"><span uk-icon="icon: ban"></span> Canceled:</span>')
                    UIkit.notification("<span uk-icon='icon: warning'></span> "+ media.message, {pos: 'top-center', status:'warning'})
                } else if(status = {{\App\Modules\Media\Media::UPLOAD_TYPE_COMPLETED}}){
                    UIkit.notification("<span uk-icon='icon: check'></span> "+ media.message, {pos: 'top-center', status:'success'})
                    // insert media
                    if (type == {{\App\Modules\Media\Media::TYPE_VIDEO}}){
                        video = '<video src="'+url+'" loop muted playsinline controls disablepictureinpicture controlsList="nodownload"></video>';
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
                    processStatus.find('.process-word').html('<span class="uk-text-success"><span uk-icon="icon: check"></span> Completed:</span>')

                }
                resetUploadForm(false);
            },
            error: function (e) {
                resetProgressBar();
                UIkit.notification("<span uk-icon='icon: warning'></span> "+ "Unable to upload media, max file size is 500MB.", {pos: 'top-center', status:'danger'})
                resetUploadForm();
                processStatus.find('.process-percentage').html('<span class="">0%</span>')
            }
        });
    });

    function deleteResourceItem(){
        $('.resource-delete').click(function (){
            var btn = $(this);
            var resource =  btn.closest('.resource-item');
            var resourceId =  resource.attr('id').split('-')[1];
            UIkit.modal.confirm('Are you sure that you want to delete this item?').then(function () {
                resource.remove();
            }, function () {
                return false;
            });
            $('.removed-resources-items').append('<input type="hidden" name="removed-resources[]" value="'+resourceId+'">');
        });
    }
    deleteResourceItem();
</script>