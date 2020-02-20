@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._pages'))
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection

@section('content')
<section>
    @if(!empty($page))
        {!! Form::open(['url' => route('pages.update', $page->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @else
        {!! Form::open(['url' => route('pages.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @endif
    @include('manage.partials._page-header')
    <div class="form-panel row">
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Basic input')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('title',!empty($page) ? $page->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Slug title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('slug',!empty($page) ? $page->slug : null,['class' => 'form-control slug','required' => true,'placeholder' => 'slug-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Content')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::textarea('body',!empty($page->body) ? $page->body : null,['class' => 'form-control content-editor']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row col-lg-12 padding-0 margin-0">
                <div class="col-lg-7 properties">
                    <div class="card border-light" style="min-height: 350px">
                        <div class="card-body">
                            <p>{{__('Properties')}}</p>
                            <hr>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Status')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($page) || !empty($page->status) ? 'checked' : null}}>
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Banners')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::select('banner_id',[null =>'-- Please select banner --'] + $banners, !empty($page) ? $page->banner_id : null ,["class" => "form-control"]) !!}
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
                                $image_source = (!empty($page) && !empty($page->image)) ? asset_image($page->image) : null;
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
<section id="panel-form">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-light">
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{__('Title')}}:</label>
                    </div>
                    <div class="col-md-10 {{ $errors->has('title') ? ' has-error' : '' }}">
                        {!! Form::text('title',!empty($page) ? $page->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{__('Slug url')}}:</label>
                    </div>
                    <div class="col-md-6 {{ $errors->has('url') ? ' has-error' : '' }}">
                        {!! Form::text('slug',!empty($page) ? $page->slug : null,['class' => 'form-control slug','required' => true,'placeholder' => 'page-title']) !!}
                          @if ($errors->has('url'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('url') }}</strong>
                              </span>
                          @endif
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
                        <label>{{__('Content')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <textarea id="addpage" name="body" class="form-control" rows="6" placeholder=""></textarea>

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
                      {!! Form::select('banner_id',[null => '-- Please select banner --']+$banners,null,["class" => "form-control"]) !!}
                  </div>
                </div>
      
                <div><br></div>
                
                <!--form item-->
                <div class="form-group">
                  <div class="col-lg ">
                        @Include('layouts.partials.modals._add_image')
                  </div>
                </div>

                

                <!--form item-->
                
            </div>
        </div>      
    </div>
</section>
@endif
@endsection
@section('script')
    <script>
        var title = $('.title');
        var slug = $('.slug');
        title.on('input', function(){
            var slag_input = $(this).val().replace(/ /g,"-").toLowerCase();
            slug.val(slag_input);
        });
    </script>
@endsection
