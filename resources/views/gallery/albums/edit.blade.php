@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._albums'))
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')

<section>
@if(!empty($album))
    {!! Form::open(['url' => route('albums.update', $album->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
@else
    {!! Form::open(['url' => route('albums.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
@endif
@include('manage.partials._page-header')
    <div class="form-panel row">
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
                                    {!! Form::text('title',!empty($album) ? $album->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Category')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    {!! Form::textarea('description',!empty($album->description) ? $album->description : null,['class' => 'form-control','rows' => '5']) !!}
                                </div>
                            </div>
                            <div class="form-group row col-lg-12 padding-0 margin-0">
                                <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Status')}}</div>
                                <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                    <input type="checkbox" name="status" class="toogle-switch" value="1" {{($album->status == '1') ? 'checked' : ''}}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}

</section>
@endsection
