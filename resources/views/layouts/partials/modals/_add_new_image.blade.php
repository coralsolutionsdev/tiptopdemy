<!-- Button trigger modal -->
<div class="text-right">
    <button type="button" class="btn btn-primary btn-lg w-75" data-toggle="modal" data-target="#newimagemodal"><span class="fa fa-cloud-upload" aria-hidden="true"></span> <span>{{trans('main._upload')}}</span></button>
</div>
<!-- Modal -->
<form method="POST" action="{{route('images.store')}}" enctype="multipart/form-data" data-parsley-validate>
      {{csrf_field()}}
<div class="modal fade" id="newimagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">{{trans('main._upload')}} {{trans('main._pictures')}}</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="form-group ">
            @php
                $attachments_count = 2;
                $image_source = null;
            @endphp
            @include('manage.partials._files-uploader')
{{--              <input class="form-control section" type="file" name="image[]" multiple>--}}
          </div>

          <div class="form-group">
              <input type="text" name="title" class="form-control" value="" placeholder="{{trans('main._title')}}" required>
          </div>

          <div class="form-group">
              <textarea name="description" class="form-control" placeholder="{{trans('main._description')}} ...."></textarea>
          </div>

          <div class="form-group">
              <select name="album_id" class="form-control" required>
                    <option disabled selected value> -- {{trans('main._album_select')}} -- </option>
                    @foreach($albums as $album)
                    <option value="{{$album->id}}">{{ucfirst($album->title)}}</option>
                    @endforeach
              </select>

          </div>

          <div class="form-group row">
            <div class="col-md-3 text-left">{{trans('main._status')}}:</div>
            <div class="col-md-9 d-flex justify-content-start">
                <input type="checkbox" name="status" class="toogle-switch" value="1" checked>
            </div>
            
          </div>


      </div>
      <div class="modal-footer">
        <div class="form-group col-12">
              <button type="submit" name="submit" class="btn btn-light btn-lg col-12" >{{trans('main._add')}}</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>