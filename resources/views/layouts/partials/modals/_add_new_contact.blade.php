<!-- Button trigger modal -->
<div class="text-center">
    <button type="button" class="btn btn-primary btn-lg col-lg" data-toggle="modal" data-target="#newcategorymodal"><span class="fa fa-plus-circle" aria-hidden="true"></span>  <span>{{trans('main._add')}}</span></button>
</div>
<!-- Modal -->
<form method="POST" action="{{route('contacts.store')}}" enctype="multipart/form-data" data-parsley-validate>
      {{csrf_field()}}
<div class="modal fade" id="newcategorymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">{{trans('main._add')}} {{trans('main._contact')}}</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
              <input type="text" name="title" class="form-control" value="" placeholder="{{trans('main._title')}}" required>
          </div>

          <div class="form-group">
              <select name="type" class="form-control" required>
              <option disabled selected value> -- {{trans('main._select')}} {{trans('main._contact')}} -- </option>
              <option value="contact-body">Contact Text</option>
              <option value="location">location</option>
              <option value="email">Email</option>
              <option value="phone">Phone</option>
              <option value="facebookr">Facebookr</option>
              <option value="twitter">Twitter</option>
              <option value="instegram">instegram</option>
              <option value="youtube">youtube</option>
              </select>
          </div>

          <div class="form-group">
              <input type="text" name="link" class="form-control" value="" placeholder="{{trans('main._link')}}">
          </div>


          <div class="form-group">
              <textarea name="body" class="form-control" placeholder="{{trans('main._description')}}  ...."></textarea>
          </div>

          <div class="form-group row">
            <div class="col-md-3">{{trans('main._status')}}:</div>
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