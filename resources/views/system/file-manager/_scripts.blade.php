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
        $('.media-item,.media-preview').off('click').click(function (){
            var wrapper = $(this).closest('.media-wrapper')
            var item = wrapper.find('.media-item');
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

    function copyMediaUrl(){
        $('.copy-url-btn').off('click').click(function (){
            var btn = $(this);
            var btnId = btn.attr('id').split('-')[1];
            var item = $('#mediaItem-'+btnId);
            var url = item.attr('url-value');
            copyToClipboard(url);
            UIkit.notification("<span uk-icon='icon: check'></span> MediaFile url copied to clipboard.", {pos: 'top-center', status:'success'})

        });
    }
    function deleteMediaItem(id)
    {
        UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to delete this media item?').then(function() {
            $.post('/manage/media/ajax/delete/'+id).done(function (response){
                $('#mediaItem-'+id).closest('.media-wrapper').remove();
            });

        }, function () {
            console.log('Rejected.')
        });
    }
    var mediaItemOnMoveId = null;
    var openedGroupSlug = null;

    function pasteMediaItem()
    {
        $('.paste-moved-media').click(function (){
            var data = {
                id:mediaItemOnMoveId,
                group_slug:openedGroupSlug
            }
            $.post('{{route('media.ajax.move')}}', data)
                .done(function (response) {
                    $('.paste-moved-media').hide();
                    console.log(response)
                    fetchMedia(openedGroupSlug);
                    fetchGroups(openedGroupSlug);
                    UIkit.notification(response.statusMessage, {pos: 'top-center', status:response.statusText})

                });
        });
    }
    pasteMediaItem();
    function mediaItemActions()
    {
        $('.delete-media-item').off('click').click(function (){
            var btn = $(this);
            var btnId = btn.attr('id').split('-')[1];
            deleteMediaItem(btnId)
        });
        $('.media-delete').off('click').click(function (){
            var wrapper = $(this).closest('.media-wrapper')
            var item = wrapper.find('.media-item');
            var btnId = item.attr('id').split('-')[1];
            deleteMediaItem(btnId)
        });
        $('.media-move').off('click').click(function (){
            var wrapper = $(this).closest('.media-wrapper')
            var item = wrapper.find('.media-item');
            item.find('img').addClass('on-move');
            wrapper.find('.actions-dropdown').toggle();
            $('.paste-moved-media').show();
            var btnId = item.attr('id').split('-')[1];
            mediaItemOnMoveId = btnId;
        });
        $('.open-actions-dropdown').off('click').click(function (){
            $(this).parent().find('.actions-dropdown').toggle();
        });



    }
    function resetGroupForm(){
        var titleInput = $('.group-title');
        titleInput.removeClass('uk-form-danger');
        titleInput.val('');
    }
    function openGroup(){
        $('.media-group').off('dblclick').dblclick(function (){
            var item =  $(this);
            var itemSlugId =  item.attr('id').split('-')[1];
            openedGroupSlug = itemSlugId;
            $('.file-uploader-group').val(openedGroupSlug);
            fetchGroups(itemSlugId);
            fetchMedia(itemSlugId);
        });
    }
    function drawMediaGroup(item){
        var groupIcon = '{{asset_image('assets/file_icons/folder.png')}}';
        $('.file-manager-folders').append(`<div>
            <div id="mediaGroup-`+item.slug+`" class="media-group uk-grid-collapse uk-padding-small" uk-grid style="background-color: #F2F4F4; border: 1px #DFE3E7;">
                <div class="uk-width-1-3 uk-flex uk-flex-middle">
                    <img data-src="`+groupIcon+`" width="50" height="" alt="" uk-img>
                </div>
                <div class="uk-width-2-3 uk-flex uk-flex-middle">
                    <div>
                        <p class="uk-margin-remove">`+item.title+`</p>
                        <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">`+item.sub_groups+` Folders</p>
                        <p class="uk-margin-remove uk-text-muted" style="font-size: 12px">`+item.items_count+` Files</p>
                    </div>
                </div>
            </div>
        </div>`);
        openGroup();
    }

    function createNewGroup(){
        $('.create-media-group').off('click').click(function (){
            var titleInput = $('.group-title');
            var titleValue = titleInput.val();
            titleInput.removeClass('uk-form-danger');
            if (titleValue == undefined || titleValue.length < 1){
                UIkit.notification("<span uk-icon='icon: ban'></span> Please add a folder name first.", {pos: 'top-center', status:'danger'})
                titleInput.addClass('uk-form-danger');
                return false;
            }
            var data = {
                'title': titleValue,
                'ancestor_slug': openedGroupSlug,
            };
            $('.create-media-group').attr('disabled', true);
            $('.group-process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.6"></div></span>')
            $('.group-process-status').html('<span class="uk-text-primary"> Creating</span>');
            $.post('/manage/system/group/ajax/create',data).done(function (item){
                resetGroupForm();
                drawMediaGroup(item);
                $('.group-process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                $('.group-process-status').html('<span class="uk-text-success"> Created successfully.</span>');
                $('.create-media-group').attr('disabled', false);
            });
        });
    }
    createNewGroup()

    function drawMediaItem(item)
    {
        var imageUrl = '{{asset_image('assets/file_icons/')}}'+'/'+item.extension+'.png';
        var prevTag = '<div class="uk-padding"><img data-src="'+imageUrl+'" width="50" height="" alt="" uk-img></div>'
        if (item.file_type == "image"){
            imageUrl = item.url;
            prevTag = '<img data-src="'+imageUrl+'" sizes="(min-width: 650px) 650px, 100vw"  height="" alt="" uk-img>'
        }
        $('.file-manager-items').prepend(`
                   <div class="media-wrapper" >
                    <div style="position: absolute; margin: 6px 2px">
                        <a class="open-actions-dropdown"><span uk-icon="icon: more-vertical"></span></a>
                        <div class="actions-dropdown uk-padding-small bg-white uk-box-shadow-medium" style="min-width:150px; display: none">
                            <ul class="uk-list">
                                <li><a style="display: block" class="media-preview">Preview</a></li>
                                <li><a style="display: block" class="media-move">Move</a></li>
                                <li><a style="display: block" class="media-delete">Delete</a></li>
                             </ul>
                        </div>
                    </div>
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
        mediaItemActions();
    }
    @if(false)
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
    @endif
    function fetchMedia(group = null){
        $('.loading-spinner').show();
        var data = {
            group:group,
            type:null
        }
        $.get('{{ route('media.get.library.items')}}', data)
            .done(function (response) {
                $('.file-manager-items').html('');
                $('.file-manager-image-items').html('');
                $('.file-manager-video-items').html('');
                $.each( response, function( key, media ) {
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
    }

    function fetchGroups(ancestorSlug = null){
        $('.loading-spinner').show();
        var data = {
            ancestor_slug:ancestorSlug
        }
        $.get('/manage/system/group/ajax/get/type/'+1+'/groups', data)
            .done(function (response) {
                $('.file-manager-folders').html('');
                $.each( response, function( key, item ) {
                    drawMediaGroup(item);
                });
            });
    }
    $('.home-folder').click(function (){
        openedGroupSlug = null;
        fetchMedia();
        fetchGroups();
    });

    fetchMedia();
    fetchGroups();

    $( document ).ajaxComplete(function() {
        $('.loading-spinner').fadeOut();
    });
</script>