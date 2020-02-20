
<form method="POST" action="{{route('banners.store')}}" enctype="multipart/form-data" data-parsley-validate>
      {{csrf_field()}}
<div class="text-center">
    <button type="button" class="btn btn-primary btn-lg col-lg" data-toggle="modal" data-target="#newbannermodal"><span class="fa fa-plus-circle" aria-hidden="true"></span>  <span>{{trans('main._add')}}</span></button>
</div>
  <div id="newbannermodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"><h3>{{trans('main._add')}}</h3></div>
        <div class="modal-body">

          <div class="">
            <div class="form-group col-md-6">

              <div class="form-group">
                  <input type="text" name="title" class="form-control" value="" placeholder="{{trans('main._title')}}" required>
              </div>

              <div class="form-group">
                  <textarea name="body" class="form-control" placeholder="{{trans('main._description')}} ...."></textarea>
              </div>

              <div class="form-group">
                  <input type="text" name="link" class="form-control" placeholder="{{trans('main._add')}}">
              </div>

              <input type="hidden" name="type" value="carousel">


              <div class="form-group">
                  <select name="font_color" class="form-control" required>
                  <option disabled selected value> -- select an option -- </option>
                  <option value="dark" selected)>dark</option>
                  </select>
              </div>

             
              <div class="form-group row">
                    <div class="col-md-8">{{trans('main._status')}}:</div>
                    <div class="col-md-4">
                        <input type="checkbox" name="status" class="toogle-switch" value="1" checked>
                    </div>
                    <br>
                    <br>
              </div>
            </div>


            <div class="form-group col-md-6">
              
              <div class="form-group ">
                    @Include('layouts.partials.modals._add_image')
              </div>

            </div>
          </div>  

          

          <div class="form-group">
          <button type="submit" name="submit" class="btn btn-primary btn-lg col-12" >{{trans('main._submit')}}</button>
          </div>

          
        </div>
      </div>
    </div>
  </div>
</form>