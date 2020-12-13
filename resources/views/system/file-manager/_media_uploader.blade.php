@if(false)
<div id="media-form">
    <div class="js-upload uk-placeholder uk-text-center uk-margin-remove">
        <div uk-form-custom>
            <input type="hidden" class="media_type" value="{{$mediaOwner}}">
            <input id="upload_file" type="file" class="uploader-input" name="media_files[]" accept="image/*" multiple>
            <button class="uk-button uk-button-default uk-button-upload" type="button" tabindex="-1">{{__('main.Click to attach your files')}} <span uk-icon="icon: cloud-upload"></span></button>
        </div>
        <div class="uploader-items">

        </div>
    </div>
    <div class="uk-margin-small process-status">
        <span class="process-word"></span> <span class="process-percentage"></span>
    </div>
    <div>
        <progress id="js-progressbar" class="uk-progress" value="0" max="100" style="display: none"></progress>
    </div>
    <div class="removed-media-items">
    </div>
</div>
@endif
<form id="dropzoneMediaForm" action="{{route('media.store')}}" class="dropzone uk-width-1-1 uk-flex uk-flex-center" id="myAwesomeDropzone" enctype="multipart/form-data">
    @csrf
</form>
