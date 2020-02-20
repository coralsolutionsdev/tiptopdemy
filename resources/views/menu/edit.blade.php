@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._menus'))
@section('content')

<form method="POST" action="{{route('menus.update', $menu->id)}}}" enctype="multipart/form-data" data-parsley-validate>
    {{csrf_field()}} {{method_field('PUT')}}

<section class="page-header">
    <div class="row">
        <div class="col-md-6">
          <h2>@yield('title')</h2>
            <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._menus')}} / {{trans('main._update')}}</p></small>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
      <div class="col-5">
      <button type="submit" name="submit" class="btn btn-success btn-lg col-12" >{{trans('main._update')}}</button>  
      </div>        
    </div>
    </div>
</section>
<section id="panel-form">
    <div class="row card border-light">
        <div class="col-md-8">
            <div class="">
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._title')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="title" class="form-control" value="{{$menu->title}}" required>
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._link')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="link" class="form-control" value="{{$menu->link}}" required>
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._order')}}:</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="order_id" class="form-control" value="{{$menu->order_id}}" required>
                    </div>
                </div>
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._position')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <select name="position" class="form-control" required>
                          <option disabled selected value> -- {{trans('main._select')}} {{trans('main._position')}} -- </option>
                          <option value="header"{{($menu->position == 'header') ? 'selected' : ''}}>header</option>
                          <option value="footer" {{($menu->position == 'footer') ? 'selected' : ''}}>footer</option>
                          <option value="header-footer" {{($menu->position == 'header-footer') ? 'selected' : ''}}>header-footer</option>
                      </select>
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._status')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" name="status" class="toogle-switch" value="1" {{($menu->status == '1') ? 'checked' : ''}}>
                    </div>
                </div>  
                <!--form item-->
                
                
                <!--form item-->
            </div>
        </div>      
              
    </div>
</section>
</form>
@endsection
