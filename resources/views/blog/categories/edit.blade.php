@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._categories'))
@section('content')

<form method="POST" action="{{route('categories.update', $category->id)}}}" enctype="multipart/form-data" data-parsley-validate>
    {{csrf_field()}} {{method_field('PUT')}}

<section class="page-header">
    <div class="row">
        <div class="col-md-6">
          <h2>@yield('title')</h2>
            <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._categories')}} / {{trans('main._update')}}</p></small>
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
                        <input type="text" name="title" class="form-control" value="{{$category->title}}" required>
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._status')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" name="status" class="toogle-switch" value="1" {{($category->status == '1') ? 'checked' : ''}}>
                    </div>
                </div>  
                <!--form item-->
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._body')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <textarea name="description" rows="5" class="form-control" placeholder="Post desicription ....">{{$category->description}}</textarea>

                    </div>
                </div>
                
                <!--form item-->
            </div>
        </div>      
              
    </div>
</section>
</form>
@endsection
