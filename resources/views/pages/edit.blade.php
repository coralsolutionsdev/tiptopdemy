@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._pages'))
@section('stylesheet')
      selector: 'textarea#addpage',
@endsection

@section('content')
<form method="POST" action="{{route('pages.update', $page->id)}}" enctype="multipart/form-data" data-parsley-validate>
{{csrf_field()}} {{method_field('PUT')}}

<section class="page-header">
    <div class="row">
        <div class="col-md-6">
          <h2>@yield('title')</h2>
            <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._pages')}} / {{trans('main._update')}}</p></small>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
      <div class="col-5">
      <button type="submit" name="submit" class="btn btn-success btn-lg col-12" >{{trans('main._update')}}</button>  
      </div>        
    </div>
    </div>
</section>
<section id="panel-form">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-light">
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._post_title')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="title" class="form-control" value="{{$page->title}}" required>
                  </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._link')}}:</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="url" class="form-control" value="{{$page->url}}" placeholder="page-title" required>
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._status')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" name="status" class="toogle-switch" value="1" {{($page->status == '1') ? 'checked' : ''}}>
                    </div>
                </div>  
                <!--form item-->
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._body')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <textarea id="addpage" name="body" class="form-control" rows="6" placeholder="Post Body ....">{{$page->body}}</textarea>

                    </div>
                </div>
                
                <!--form item-->
            </div>
        </div>      
        <div class="col-md-4">
            <div class="card border-light">
              
                <!--form item-->
                <div class="form-group">
                  <div class="col-lg ">
                        <select name="banner" class="form-control">
                            <option disabled value {{($page->banner == null) ? 'selected' : ''}}> -- {{trans('main._select')}} {{trans('main._banner')}} -- </option>

                            @foreach($banners as $banner)
                              <option value="{{$banner->id}}" {{($page->banner == $banner->id) ? 'selected' : ''}}>{{$banner->title}}</option>
                            @endforeach
                            <option value="none"> -- none -- </option>
                        </select>
                  </div>
                </div>
      
                <div><br></div>
                
                <!--form item-->
                <div class="form-group">
                  <div class="col-lg ">
                        @section('imagesource')
                        @if ( !empty ( $page->image ) ) 
                        src="{{asset('/uploads/pages/images/'.$page->image)}}"
                        @endif
                        @endsection
                        @Include('layouts.partials.modals._add_image')
                  </div>
                </div>

                

                <!--form item-->
                
            </div>
        </div>      
    </div>
</section>
</form>
@endsection
