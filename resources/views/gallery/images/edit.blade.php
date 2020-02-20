@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._images'))
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection

@section('content')
<section>
    @if(!empty($image))
        {!! Form::open(['url' => route('images.update', $image->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @else
        {!! Form::open(['url' => route('posts.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @endif
    @include('manage.partials._page-header')
    <div class="form-panel row">
        @if(false)
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Basic input')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('title',!empty($post) ? $post->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Slug title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('slug',!empty($post) ? $post->slug : null,['class' => 'form-control slug','required' => true,'placeholder' => 'slug-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Content')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::textarea('content',!empty($post->content) ? $post->content : null,['class' => 'form-control content-editor']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-lg-12">
            <div class="row col-lg-12 padding-0 margin-0">
                <div class="col-lg-7 properties">
                    <div class="card border-light" style="min-height: 350px">
                        <div class="card-body">
                            <p>{{__('Basic info')}}</p>
                            <hr>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Title')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::text('title',!empty($image) ? $image->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Description')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::textarea('description',!empty($image->description) ? $image->description : null,['class' => 'form-control','rows' => '5']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Category')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::select('album_id',[null=>'-- Please Select an album --'] + $albums,!empty($image) ? $image->album_id : null,['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Status')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($post) || !empty($post->status) ? 'checked' : null}}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 image-upload">
                    <div class="card border-light" style="min-height: 350px">
                        <div class="card-body">
                            <p>{{__('Image')}}</p>
                            <hr>
                            @php
                                $attachments_count = 1;
                                $image_source = (!empty($image) && !empty($image->image)) ? asset_image($image->image) : null;
                            @endphp
                            @include('manage.partials._files-uploader')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</section>

@if(false)

<form method="POST" action="{{route('images.update', $image->id)}}" enctype="multipart/form-data" data-parsley-validate>
      {{csrf_field()}} {{method_field('PUT')}}

<section id="panel-form">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-light">
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._title')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="title" class="form-control" value="{{$image->title}}">
                    </div>
                </div>
                
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._status')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" name="status" class="toogle-switch" value="1" checked>
                    </div>
                </div>  
                <!--form item-->
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._body')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <textarea name="description" rows="8" class="form-control" placeholder="{{trans('main._description')}} ....">{{$image->description}}</textarea>

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
                      <select name="album_id" class="form-control" required>
                      <option disabled selected value> -- {{trans('main._album_select')}} -- </option>
                      @foreach($albums as $album)
                      <option value="{{$album->id}}" {{($album->id == $image->album_id) ? 'selected' : ''}}>{{ucfirst($album->title)}}</option>
                      @endforeach
                      </select>
                  </div>
                </div>
      
                <div><br></div>
                
                <!--form item-->
                <div class="form-group">
                  <div class="col-lg ">
                      @section('image_source')
                        @if ( !empty ( $image->image ) ) 
                        src="{{asset_image($image->image)}}"
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
@endif
</form>
@endsection
