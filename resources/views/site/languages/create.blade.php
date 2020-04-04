@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
<section>
@if(!empty($language))
    {!! Form::open(['url' => route('languages.update', $language->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
@else
    {!! Form::open(['url' => route('languages.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
@endif
    @include('manage.partials._page-header')
    <div class="form-panel row">
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Basic input')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('name')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('name',!empty($language) ? $language->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Language name']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Title')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::text('code',!empty($language) ? $language->code : null,['class' => 'form-control title','required' => true,'placeholder' => 'Language Code', 'disabled' => true]) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Position')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::number('position',!empty($language) ? $language->position : 0,['class' => 'form-control title','required' => true]) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
                        <div class="col-lg-10" style="padding: 10px 0 10px 10px; margin: 0px">
                            <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($language) || !empty($language->status) ? 'checked' : null}}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}

</section>

@endsection
