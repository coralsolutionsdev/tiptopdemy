<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function resetNewMediaItem(){
        $.each($('.media_new_file_order'), function (){
            $(this).closest('li').remove();
        });
    }

    $('#upload_file').change(function (event){
        var images = event.target.files;
        resetNewMediaItem();
        $.each(images, function (i, image) {
            var render = new FileReader();
            var newImageId = generateRandomString(6);
            render.readAsDataURL(image);
            render.onload = function (e) {
                var new_image = $('.product-image-template').clone().show().removeClass('product-image-template');
                new_image.find('.product-image').attr('src',e.target.result );
                var imageUrl = e.target.result;
                var newImageItem = '' +
                    '<li id="media_item-'+newImageId+'">\n' +
                    '    <div class="uk-card uk-card-default uk-card-body uk-padding-remove">\n' +
                    '         <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger media-delete" uk-icon="icon: trash"></span></div>\n' +
                    '         <div>\n' +
                    '             <input type="hidden" name="media_id[]" value="'+newImageId+'">\n' +
                    '             <input type="hidden" name="media_position[]" value="0">\n' +
                    '             <input type="hidden" class="media_new_file_order" name="media_new_file_order[]" value="'+i+'">\n' +
                    '             <img data-src="'+imageUrl+'" sizes="(min-width: 650px) 650px, 100vw" width="650" height="433" alt="" uk-img>\n' +
                    '         </div>\n' +
                    '    </div>\n' +
                    '</li>';
                $('.media-items-list').append(newImageItem);
                deleteResourceItem();
            }
        })

    });

    function deleteResourceItem(){
        $('.media-delete').click(function (){
            var btn = $(this);
            var media =  btn.closest('li');
            var mediaId =  media.attr('id').split('-')[1];
            UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to delete this media item?').then(function() {
                media.remove();
            }, function () {
                return false;
            });
            $('.removed-media-items').append('<input type="hidden" name="media_removed_ids[]" value="'+mediaId+'">');
        });
    }
    deleteResourceItem();
    $(function () {
        var pageURL =  window.location.href;
        var tabId = pageURL.split('#')[1];
        if (tabId !== undefined){
            $('.nav-link').removeClass('active');
            $('.'+tabId+'-link').addClass('active');
            //
            $('.tab-pane').removeClass('active');
            $('.'+tabId+'-tab').addClass('active');
            $('.'+tabId+'-tab').addClass('show');
            window.scrollTo(0);
        }
    });
</script>