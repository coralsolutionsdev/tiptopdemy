@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <style>
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

@endsection
@section('content')
    <section>
        @if(!empty($product))
            {!! Form::open(['url' => route('store.products.update', $product->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('store.products.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header')
        <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Name')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('name', !empty($product) ? $product->name : null, ['class' => 'form-control', 'id' => 'name']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Slug')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('slug', !empty($product) ? $product->slug : null, ['class' => 'form-control', 'id' => 'slug', 'readonly' => true]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('SKU')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('sku', !empty($product) ? $product->sku : null, ['class' => 'form-control', 'maxlength' => 191, 'placeholder' => 'Enter SKU (Optional)']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',  !empty($product) ? $product->description : null, ['class' => 'form-control content-editor', 'rows' => '15']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Categories')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div>
                                    <span class="btn btn-primary" data-toggle="collapse" data-target="#demo">Show list of categories</span>
                                    <div id="demo" class="collapse">
                                        {{drawInputTreeListItems($tree_categories, 'categories[]',!empty($selectedCategories) ? $selectedCategories : array(), 'checktree')}}
                                    </div>
                                </div>                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Product Type')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('product_type_id', $types, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Manage Stock')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="manage_stock" class="toogle-switch manage_stock" value="1" {{empty($product) || !empty($product->manage_stock) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Quantity')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::number('quantity', !empty($product) ? $product->quantity : null, ['class' => 'form-control quantity-input', 'placeholder' => 'Enter quantity']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Price')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::number('price', !empty($product) ? $product->price : null, ['class' => 'form-control', 'required' => true, 'min' => 0, 'step' => '0.01', 'placeholder' => 'Enter price']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('status', $visibility, !empty($product) ? $product->status : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Position')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('position', (!empty($product)) ? $product->position : 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Tags')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('tags[]', $tags, $selectedTags, ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'product-tags', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Meta input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Meta Title')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('meta_title', !empty($product) ? $product->meta_title : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Meta Keywords')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('meta_keywords', !empty($product) ? $product->meta_keywords : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Meta Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('meta_description', !empty($product) ? $product->meta_description : null, ['class' => 'form-control', 'rows' => '4']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($product))
                    <div class="card border-light">
                        <div class="card-body">
                            <p>{{__('Product attributes')}}</p>
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
                @endif
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Product images')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Images')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div class="files-uploader text-center">
                                    <div style="padding: 10px;">

                                    </div>
                                    <div>
                                        <span class="btn btn-primary browse-files w-50">Browse Files</span>
                                    </div>
                                    {!! Form::file('new_image[]', ['id' => 'attachments-upload', 'style' => 'display:none', 'accept' => "application/zip, application/x-7z-compressed, application/x-rar-compressed, image/x-png, image/jpeg, image/png, application/pdf, application/msword, video/*, image/*, audio/*", 'multiple' => true]) !!}
                                </div>
                                <div class="product-images-field">
                                    @if(!empty($product) && !empty($product->getImages() ))
                                        @foreach($product->getImages() as $image)
                                            <div id="{{$image->id}}" class="product-image" style="border: 1px solid var(--theme-primary-color); margin-top: 10px;">
                                                <div class="row col-lg-12 margin-0" style="padding: 10px 0px">
                                                    <div class="col-lg-2 d-flex align-items-center">
                                                        <img class="product-image" src="{{asset_image($image->path)}}" alt="" width="120">
                                                        <input type="hidden" class="product-image-code" name="image_code[{{$image->id}}]" value="{{$image->code}}">
                                                    </div>
                                                    <div class="col-lg-7 d-flex align-items-center">
                                                        <input type="text" class="form-control" name="image_description[{{$image->id}}]" placeholder="Image description (Optional)" value="{{$image->description}}">
                                                    </div>
                                                    <div class="col-lg-2 d-flex align-items-center">
                                                        <input type="number" class="form-control" name="image_position[{{$image->id}}]" placeholder="Position" value="{{$image->position}}">
                                                    </div>
                                                    <div class="col-lg-1 d-flex align-items-center">
                                                        <span class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                <div class="product-images-deleted">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            {!! Form::close() !!}

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
        function deleteImage()
        {
            $('.btn-delete').off('click');
            $('.btn-delete').click(function () {
                if (!confirm('Are you sure that you want to remove this image?')){
                    return false;
                }
                var item =  $(this).parent().parent().parent();
                var itemId = item.attr('id');
                if (itemId !== '' && itemId !== undefined){
                    $('.product-images-deleted').append('<input type="hidden" name="image_deleted[]" value="'+itemId+'">');
                }
                item.remove();
            });
        }
        $('.drag-area,.browse-files,.image-area').click(function()
        {
            $('#attachments-upload').click();
        });
        $('#attachments-upload').change(function(event)
        {
            var images = event.target.files;
            $.each(images, function (i, image) {
                var render = new FileReader();
                var code = generateRandomString(6);
                render.readAsDataURL(image);
                render.onload = function (e) {
                    var new_image = $('.product-image-template').clone().show().removeClass('product-image-template');
                    new_image.find('.product-image').attr('src',e.target.result );
                    new_image.find('.product-image-code').val(code);
                    new_image.attr('id',code);
                    $('.product-images-field').append(new_image);
                    deleteImage();
                }
            })
        });
        deleteImage();

        $('.manage_stock').change(function () {
            if ($(this).is(":checked")) {
                $('.quantity-input').attr('readonly',false);
            }else {
                $('.quantity-input').val(0).attr('readonly',true);
            }
        });
    </script>

@endsection
