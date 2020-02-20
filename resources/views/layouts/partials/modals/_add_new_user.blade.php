<!-- Button trigger modal -->
<div class="text-right">
    
    <button type="button" class="btn btn-primary btn-lg w-75" data-toggle="modal" data-target="#newalbummodal">
      <span class="fa fa-plus-circle" aria-hidden="true"></span>  <span>{{trans('main._add')}} {{trans('main._user')}}</span>
    </button>
</div>
<!-- Modal -->
<form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data" data-parsley-validate>
      {{csrf_field()}}
<div class="modal fade" id="newalbummodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="exampleModalLabel"><span>{{trans('main._add')}} {{trans('main._user')}}</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        

      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{trans('main._name')}}" required autofocus>

          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>
  

      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
      
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{trans('main._email')}}" required>

          @if ($errors->has('email'))
              <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
      </div>

      <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
         <select name="gender" id="gender" class="custom-select col-12 form-control-dropdown" required>
          <option selected class="" disabled>-- {{trans('main._gender')}} --</option>
          <option value="1">{{trans('main._male')}}</option>
          <option value="0">{{trans('main._female')}}</option>
          </select>

          @if ($errors->has('gender'))
              <span class="help-block">
                  <strong>{{ $errors->first('gender') }}</strong>
              </span>
          @endif
      </div>
      <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
         <select name="role" id="role" class="custom-select col-12 form-control-dropdown" required>
             @foreach($roles as $item)
                 <option value="{{$item->id}}"{{($item->name == 'user') ? 'selected':''}}>{{$item->name}}</option>
             @endforeach
          </select>

          @if ($errors->has('role'))
              <span class="help-block">
                  <strong>{{ $errors->first('gender') }}</strong>
              </span>
          @endif
      </div>

  
      
  
      <div class="form-row">
          <div class="form-group col-6{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="{{trans('main._password')}}"  required>

              @if ($errors->has('password'))
                  <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
          </div>

          <div class="form-group col-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('main._confirm')}} {{trans('main._password')}}" required>
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