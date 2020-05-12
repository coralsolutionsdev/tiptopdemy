<script>
    var storeUrl =  '{{ route('attachment.image.upload', array(), false) . '?_token=' . csrf_token() }}';
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
        toolbar1: "undo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect link| image media | forecolor backcolor | link unlink anchor | fontsizeselect forecolor backcolor  | print preview code fullscreen | pagebreak",
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
                // // add input
                // var imageId = generateRandomString(4);
                // $('#post-images').append('<div class="row d-flex align-items-center post-images-item"><div class="col-6"><img src="'+json.item.url+'" width="100" alt=""><input type="hidden" name="images['+imageId+']" value="'+json.item.path+'"></div><div class="col-6 d-flex justify-content-end"><span id="'+imageId+'" class="btn btn-light btn-post-delete"><i class="far fa-trash-alt"></i></span></div></div>');
                // deleteImage();
                success(json.item.url);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);

        }

    });
</script>