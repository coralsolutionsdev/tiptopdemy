<div class="files-uploader text-center">
    <div style="padding: 20px 0; min-height: 170px">
        <div class="drag-area" style="{{!empty($image_source) ? 'display: none' : ''}}">
            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; padding-bottom: 20px"></i>
            <p style="font-size: 16px">Drag and drop files here</p>
            <span>or</span>
        </div>
        <div class="image-area">
            <img id="output" src="{{!empty($image_source) ? $image_source : ''}}" alt="" style="width: 100%; top: 0px">
        </div>
    </div>
    <div id="attached-file-template" class="selected-email inline-center ellipsis-text" style="display: none;">
        <i class="far fa-image"></i>
        <span class="file-name" style="font-size: 12px; font-style: italic;"></span>
    </div>
    <div>
        <span class="btn btn-primary browse-files w-50">Browse Files</span>
    </div>
    @if($attachments_count == 1)
        {!! Form::file('image', ['id' => 'attachments-upload', 'style' => 'display:none', 'accept' => "application/zip, application/x-7z-compressed, application/x-rar-compressed, image/x-png, image/jpeg, image/png, application/pdf, application/msword, video/*, image/*, audio/*", 'multiple' => true]) !!}
    @else
        {!! Form::file('image[]', ['id' => 'attachments-upload', 'style' => 'display:none', 'accept' => "application/zip, application/x-7z-compressed, application/x-rar-compressed, image/x-png, image/jpeg, image/png, application/pdf, application/msword, video/*, image/*, audio/*", 'multiple' => true]) !!}
    @endif
</div>
<script>
    $('.drag-area,.browse-files,.image-area').click(function()
    {
        $('#attachments-upload').click();
    });
    $('#attachments-upload').change(function(event)
    {
        var image_counts = '{{$attachments_count}}';
        if (image_counts == 1){
            $('.drag-area').slideUp();
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }else {
            var file_names = $.map($(this).prop('files'), function(file)
            {
                return file.name;
            });
            var file_section = $('.drag-area');
            file_section.html('');
            var new_file = null;
            file_section.html('');
            file_names.map(function(file_name)
            {
                new_file = $('#attached-file-template').clone().css('display', '');
                new_file.find('.file-name').html(file_name);
                file_section.append(new_file);
            });
        }

    });
</script>