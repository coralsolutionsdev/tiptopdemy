@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($product)? __('main.Save changes') : __('main.submit')}}</span></button>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <style>
        html, body{
            /*height: 100%;*/
        }
        .select2-container--default .select2-selection--multiple{
            border-radius: 2px !important;
            border: 1px solid #CED4DA;
        }
        .color-option{
            height: 22px;
            width: 22px;
            border-radius: 50%;
            border: 1px solid #566573;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="{{url('/plugins/date_picker/css/bootstrap-datetimepicker.min.css')}}">
    <script src="{{url('/plugins/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <section>
        @if(!empty($product))
            {!! Form::open(['url' => route('store.products.update', $product->slug),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('store.products.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header')
        <div class="form-panel row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link product-info-link active" id="product-info-tab" data-toggle="tab" href="#product-info" role="tab" aria-controls="product-info" aria-selected="true">{{__('main.Product info')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link images-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">{{__('main.Images')}}</a>
                    </li>
                    @if(!empty($product))
                    <li class="nav-item">
                        <a class="nav-link attributes-link" id="attributes-tab" data-toggle="tab" href="#attributes" role="tab" aria-controls="attributes" aria-selected="false">{{__('main.Attributes')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link lessons-link" id="lessons-tab" data-toggle="tab" href="#lessons" role="tab" aria-controls="lessons" aria-selected="false">{{__('main.Lessons')}}</a>
                    </li>
                    @endif

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show product-info-tab active" id="product-info" role="tabpanel" aria-labelledby="product-info-tab">
                    {{--tab content--}}
                        <div class="card border-light">
                            <div class="card-body">
                                <p>{{__('main.Basic input')}}</p>
                                <hr>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Title')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::text('name', !empty($product) ? $product->name : null, ['class' => 'form-control', 'id' => 'name']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('Slug')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::text('', !empty($product) ? $product->slug : null, ['class' => 'form-control', 'id' => 'slug', 'readonly' => true]) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.SKU')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::text('sku', !empty($product) ? $product->sku : null, ['class' => 'form-control', 'maxlength' => 191, 'placeholder' => 'Enter SKU (Optional)']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Description')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::textarea('description',  !empty($product) ? $product->description : null, ['class' => 'form-control content-editor', 'rows' => '15']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Category')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        <div>
                                            <span class="btn btn-primary" data-toggle="collapse" data-target="#demo">{{__('main.Show list of categories')}}</span>
                                            <div id="demo" class="collapse">
                                                {{drawInputTreeListItems($tree_categories, 'categories[]',!empty($selectedCategories) ? $selectedCategories : array(), 'checktree')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Type')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::select('product_type_id', $types, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Manage Stock')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        <input type="checkbox" name="manage_stock" class="toogle-switch manage_stock" value="1" {{empty($product) || !empty($product->manage_stock) ? 'checked' : null}}>
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Quantity')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::number('quantity', !empty($product) ? $product->quantity : null, ['class' => 'form-control quantity-input', 'placeholder' => 'Enter quantity', 'readonly' => !empty($product) && $product->manage_stock == 0 ? 'true' : 'false']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Price')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::number('price', !empty($product) ? $product->price : null, ['class' => 'form-control', 'required' => true, 'min' => 0, 'step' => '0.01', 'placeholder' => 'Enter price']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Status')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::select('status', $visibility, !empty($product) ? $product->status : null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Position')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::text('position', (!empty($product)) ? $product->position : 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Tags')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::select('tags[]', $tags, $selectedTags, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'product-tags', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card border-light">
                            <div class="card-body">
                                <p>{{__('admin.Acceptable scopes')}} <span class="Loading-status"></span></p>
                                <hr>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2">{{__('admin.Scope options')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <select name="scope_id" class="form-control scope">
                                                        @foreach(getInstitutionScopes() as $scope)
                                                            <option value="{{$scope->id}}" {{(!empty($product) && $product->scope_id == $scope->id) || (empty($product) && $scope->default == 1)  ? 'selected' : ''}} title="{{$scope->description}}">{{$scope->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group fields-section">
                                                    <select name="field_id" class="form-control fields-items fields">
                                                        <option selected="true" disabled="disabled">Study field</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <select name="level" class="form-control field-level-options">
                                                        <option selected="true" disabled="disabled">Study level</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group fields-items-section">
                                                    <select name="field_option_id" class="form-control field-item-options">
                                                        <option selected="true" disabled="disabled">Study type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
{{--                                        {!! Form::select('product_type_id', $types, null, ['class' => 'form-control']) !!}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-light">
                            <div class="card-body">
                                <p>{{__('main.Appearance')}}</p>
                                <hr>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Color pattern')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        <div class="row">
                                            @foreach($colorPatterns as $colorPattern)
                                                <div class="col-3" >
                                                    <div class="form-check" style="margin: 5px">
                                                        <input class="form-check-input" type="radio" name="color_pattern_id" id="color-pattern-{{$colorPattern->id}}" value="{{$colorPattern->id}}" {{(!empty($product) && $product->color_pattern_id == $colorPattern->id) || $colorPattern->default == 1 ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="color-pattern-{{$colorPattern->id}}" style="display: block">
                                                            <div class="text-center" style="background: linear-gradient({{$colorPattern->angle}}deg,{{str_replace(['"', '[', ']'], '', json_encode($colorPattern->gradient))}}); padding: 15px 20px; color: white; cursor: pointer; border-radius: 5px">
                                                            {{$colorPattern->title}}
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-light">
                            <div class="card-body">
                                <p>{{__('main.Meta input')}}</p>
                                <hr>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Meta Title')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::text('meta_title', !empty($product) ? $product->meta_title : null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Meta Keywords')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::text('meta_keywords', !empty($product) ? $product->meta_keywords : null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Meta Description')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        {!! Form::textarea('meta_description', !empty($product) ? $product->meta_description : null, ['class' => 'form-control', 'rows' => '4']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade images-tab" id="images" role="tabpanel" aria-labelledby="images-tab">
                        <div class="card border-light">
                            <div class="card-body">
                                <p>{{__('main.Product images')}}</p>
                                <hr>
                                <div class="form-group row col-lg-12">
                                    <div class="col-lg-2 d-flex align-items-center">{{__('main.Images')}}</div>
                                    <div class="col-lg-10 padding-0 margin-0">
                                        <div>
                                            @include('manage.partials._media_uploader')
                                        </div>
                                        <div>
                                            <ul class="uk-grid-small uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m media-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid="masonry: true">

                                                @if(!empty($product) && $productMedia = $product->getMedia(\App\Modules\Media\Media::getGroup(\App\Modules\Media\Media::TYPE_PRODUCT_IMAGE)))
                                                    @foreach($productMedia as $image)
                                                        <li id="media_item-{{$image->id}}">
                                                            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                                                                <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger media-delete" uk-icon="icon: trash"></span></div>
                                                                <div>
                                                                    <input type="hidden" name="media_id[]" value="{{$image->id}}">
                                                                    <input type="hidden" name="media_position[]" value="0">
                                                                    <input type="hidden" name="media_new_file_order[]" value="">
                                                                    <img data-src="{{$image->getFullUrl('card')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" height="433" alt="" uk-img>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($product))
                    <div class="tab-pane fade attributes-tab" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                            <div class="card border-light">
                                <div class="card-body">
                                    <p>{{__('main.Product attributes')}}</p>
                                    <hr>
                                    @foreach($product->getAllProductAttr() as $attribute)
                                        @if($attribute->type == App\ProductAttribute::TYPE_RADIO)
                                            <div class="form-group row col-lg-12">
                                                <div class="col-lg-2 d-flex align-items-center">{{ $attribute->name }}</div>
                                                <div class="col-lg-10 padding-0 margin-0">
                                                    @foreach ($attribute->options as $option)
                                                        <div class="form-group d-flex align-items-center">
                                                            <label class="radio-inline"><input type="radio" name="{{ $attribute->id }}" value="{{ $option->value }}" {{$product->getProductAttrOptionValueById($attribute->id, $option->id) == $option->value ? 'checked' : '' }} />&nbsp &nbsp{{ $option->name }}</label>&nbsp;&nbsp;
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($attribute->type == App\ProductAttribute::TYPE_CHECKBOX)
                                            <div class="form-group row col-lg-12">
                                                <div class="col-lg-2 d-flex align-items-center">{{ $attribute->name }}</div>
                                                <div class="col-lg-10 padding-0 margin-0">
                                                    @foreach ($attribute->options as $option)
                                                        <div class="form-group d-flex align-items-center">
                                                            <input type="checkbox" name="{{ $attribute->id }}[]" class="toogle-switch manage_stock" value="{{ $option->value }}"  {!! $product->hasAttributeValue($attribute->name, $option->value) ? 'checked' : ''  !!}>&nbsp &nbsp{{ $option->name }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($attribute->type == App\ProductAttribute::TYPE_TEXT_FIELD)
                                            <div class="form-group row col-lg-12">
                                                <div class="col-lg-2 d-flex align-items-center">{{ $attribute->name }}</div>
                                                <div class="col-lg-10 padding-0 margin-0">
                                                    {!! Form::textarea($attribute->id, $product->getProductAttrValue($attribute->name), ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Enter value', 'style' => 'resize: false']) !!}
                                                </div>
                                            </div>
                                        @elseif($attribute->type == App\ProductAttribute::TYPE_TIMESTAMP)
                                            <div class="form-group row col-lg-12">
                                                <div class="col-lg-2 d-flex align-items-center">{{ $attribute->name }}</div>
                                                <div class="col-lg-10 padding-0 margin-0">
                                                    {!! Form::text($attribute->id, $product->getProductAttrValue($attribute->name), ['id' => 'timeDatePicker' , 'class' => 'form-control', 'rows' => 4, 'placeholder' => 'Enter value', 'style' => 'resize: false']) !!}
                                                </div>
                                            </div>
                                        @elseif($attribute->type == App\ProductAttribute::TYPE_COLOR)
                                            <div class="form-group row col-lg-12">
                                                <div class="col-lg-2 d-flex align-items-center">{{ $attribute->name }}</div>
                                                <div class="col-lg-10 padding-0 margin-0">
                                                    @foreach ($attribute->options as $option)
                                                        <div class="form-group d-flex align-items-center">
                                                            <input type="checkbox" name="{{ $attribute->id }}[]" class="toogle-switch manage_stock" value="{{ $option->value }}"  {!! $product->hasAttributeValue($attribute->name, $option->value) ? 'checked' : ''  !!}>&nbsp &nbsp <span class="color-option" style="background-color: {{$option->value}}"></span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                    </div>
                {!! Form::close() !!}

                    <div class="tab-pane fade lessons-tab" id="lessons" role="tabpanel" aria-labelledby="lessons-tab">
                            <div class="card border-light">
                                <div class="card-body">
                                    <p>{{__('main.Lessons')}}</p>
                                    <hr>
                                    <div style="position: fixed; right: 30px; bottom: 30px">
                                        <div class="uk-inline">
                                            <button class="uk-button uk-button-primary" type="button" style="border-radius: 50%; padding: 11px 20px"><span uk-icon="icon: plus"></span></button>
                                            <div uk-dropdown style="padding: 10px 10px 0px 10px">
                                                <div><a href="{{route('store.groups.create', $product->slug)}}" class="uk-button uk-button-default uk-button-small uk-width-1-1 uk-margin-small">{{__('main.Add new Unit')}}</a></div>
                                                <div><a href="{{route('store.lessons.create', $product->slug)}}" class="uk-button uk-button-default uk-button-small uk-width-1-1 uk-margin-small">{{__('main.Add new Lesson')}}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="unites" style="padding-top: 10px">
                                        <ul uk-accordion>

                                            @foreach($product->groups as $id => $group)
                                                <li class="unit {{$id == 0 ? 'uk-open' : ''}}">
                                                    <a class="uk-accordion-title" href="#">
                                                        <span class="text-primary">{{sprintf('%02d', $id+1)}} <span style="margin: 0 2px">|</span></span> <span style="padding: 0 5px">{{$group->title}}</span>
                                                    </a>
                                                    <div class="uk-accordion-content" style="padding:0px 5px">
                                                        <div class="uk-grid-collapse uk-child-width-1-1" uk-grid>
                                                            <div class="uk-width-expand uk-flex uk-flex-middle">
                                                                {!! $group->description !!}
                                                            </div>
                                                            <div class="uk-width-auto uk-flex uk-flex-right">
                                                                <div class="action_btn text-right">
                                                                    <ul>
                                                                        <li class="">
                                                                            <a href="{{route('store.groups.edit', [$product->slug, $group->slug])}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-primary" uk-tooltip="{{__('main.edit')}}"><i class="far fa-edit"></i> Edit</a>
                                                                        </li>
                                                                        <li class="">
                                                                            <span id="{{$group->id}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger btn-delete" uk-tooltip="{{__('main.delete')}}"><i class="far fa-trash-alt"></i> Delete</span>
                                                                            <form id="delete-form" method="post" action="{{route('store.groups.destroy', [$product->slug, $group->slug])}}">
                                                                                {{csrf_field()}}
                                                                                {{method_field('DELETE')}}
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <table class="uk-table uk-table-justify uk-table-divider">
                                                                    <tbody>
                                                                    @forelse($group->getLessons as $itemId => $item)
                                                                        <tr>
                                                                            <td class="uk-table-shrink align-middle"><span>{{sprintf('%02d', $itemId+1)}}</span></td>
                                                                            <td class="uk-table-expand align-middle">{{$item->title}}</td>
                                                                            <td class="uk-width-small align-middle">{{$item->getType()}}</td>
                                                                            <td class="uk-width-small">
                                                                                <div class="action_btn text-right" style="width: 400px">
                                                                                    <ul>
                                                                                        <li>
                                                                                            <a href="{{route('store.get.form.templates', $item->slug)}}" class="btn btn-light">
                                                                                               {{__('main.Add Quiz')}}
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="">
                                                                                            <a target="_blank" href="{{route('store.lesson.show', [$product->slug, $item->slug])}}" class="btn btn-light"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                                                                        </li>
                                                                                        <li class="">
                                                                                            <a href="{{route('store.lessons.edit', [$product->slug, $item->slug])}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                                                                        </li>
                                                                                        <li class="">
                                                                                            <span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                                                            <form id="delete-form" method="post" action="{{route('store.lessons.destroy', [$product->slug, $item->slug])}}">
                                                                                                {{csrf_field()}}
                                                                                                {{method_field('DELETE')}}
                                                                                            </form>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="4" class="uk-text-center">{{__('main.There is no form items yet.')}}</td>
                                                                        </tr>
                                                                    @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </section>
    {{--Templaets--}}
    <section>
        <div class="product-image product-image-template" style="border: 1px solid var(--theme-primary-color); margin-top: 10px; display: none">
            <div class="row col-lg-12 margin-0" style="padding: 10px 0px">
                <div class="col-lg-2 d-flex align-items-center">
                    <img class="product-image" src="https://getuikit.com/docs/images/photo.jpg" alt="" width="120">
                    <input type="hidden" class="product-image-code" name="new_image_code[]" value="">
                </div>
                <div class="col-lg-7 d-flex align-items-center">
                    <input type="text" class="form-control" name="new_image_description[]" placeholder="Image description (Optional)">
                </div>
                <div class="col-lg-2 d-flex align-items-center">
                    <input type="number" class="form-control" name="new_image_position[]" placeholder="Position" value="0">
                </div>
                <div class="col-lg-1 d-flex align-items-center">
                    <span class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    @include('partial.scripts._institutions')
    @include('partial.scripts._tinyemc')
    @include('store.products._scripts')
    <script>
        /**
         * Set up
         */
        $("#product-tags").select2({
            tags:true, // change to false to disable add new tags
        });

            $(function () {
                $('#timeDatePicker').datetimepicker();
            });

        // generate random item code
        function generateRandomString(length) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < length; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        $('.drag-area,.browse-files,.image-area').click(function()
        {
            $('#attachments-upload').click();
        });

        $('.manage_stock').change(function () {
            if ($(this).is(":checked")) {
                $('.quantity-input').attr('readonly',false);
            }else {
                $('.quantity-input').val(0).attr('readonly',true);
            }
        });
    </script>

@endsection
