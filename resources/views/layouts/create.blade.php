@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._new_post'))
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('head')
    <style>
        .layout-items{
            list-style: none;
        }
        .layout-items li{
            display: block;
            padding: 5px;
            margin-bottom: 10px;
            /*border-left: 2px solid #3399FF;*/
            border: 1px solid #2196F3;
            margin-left: -50px;
        }
        .layout-step{
            min-height: 450px;
        }
        .add-item{
            margin-left: 10px;
            margin-right: 10px;
            /*border: 1px solid #3399FF;*/
            /*color: #3399FF;*/
            /*padding: 20px 22px;*/
            /*border-radius: 50%;*/
            /*width: 60px;*/
            /*height: 60px;*/
            /*cursor: pointer;*/
        }
        .layout .btn{
            min-width: 80px;
        }
    </style>
@endsection

@section('content')
    @if(!empty($layout))
        {!! Form::open(['url' => route('layouts.update', $layout->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @else
        {!! Form::open(['url' => route('layouts.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
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
                            {!! Form::text('title',!empty($layout) ? $layout->title : null,['class' => 'form-control','required' => true,'placeholder' => 'Title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            {!! Form::textarea('description',!empty($layout) ? $layout->description : null,['class' => 'form-control','rows' => '5', 'placeholder' => 'Item description']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
                            <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($menu) || !empty($menu->status) ? 'checked' : null}}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Basic input')}}</p>
                    <hr>
                    <div class="form-group row col-lg-12 d-flex justify-content-end margin-0" style="padding:10px 5px"><span class="btn btn-outline-secondary add-layout-item"><i class="fas fa-plus-circle"></i> {{__('Add Item')}}</span></div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8 padding-0 margin-0">
                            <ul id="sortable" class="layout-items">

                            </ul>
                            <script src="{{url('https://code.jquery.com/ui/1.12.1/jquery-ui.js')}}"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    {{--template--}}
    <section style="display: none">
        {{--template--}}
        <li class="item-template" style="display: none; background-color: white">
            <div class="row col-lg-12">
                <div class="col-lg-9 d-flex align-items-center">
                    <span class="layout-item-name"></span>
                    <div class="layout-banner-elements-data-field">

                    </div>
                </div>
                <div class="col-lg-3 text-right">
                    <span class="btn btn-light edit-layout-item"><i class="far fa-edit"></i></span>
                    <span class="btn btn-light delete-layout-item"><i class="far fa-trash-alt"></i></span>
                </div>
            </div>
        </li>
        <li class="banner-template">
            <div class="row">
                <div class="col-lg-12">
                    <input type="checkbox" name="status" class="banner-input" value="1">
                    <label for="" class="banner-name"></label>
                </div>
            </div>
        </li>
    </section>
    <section>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="editLayoutItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('Add new item')}}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-lg-12 padding-0 margin-0">
                            <div class="col-lg-12" style="padding: 5px">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row col-lg-12 padding-0 margin-0" style="padding-bottom: 10px">
                                            <div class="col-lg-12 padding-0 margin-0">
                                                {!! Form::text('', null,['class' => 'form-control modal-input-name','placeholder' => 'Title']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0">
                                            <div class="col-lg-12 padding-0 margin-0">
                                                {!! Form::textarea('',null,['id' => 'content-editor', 'class' => 'form-control modal-input-description','rows' => '15', 'placeholder' => 'Item description']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-lg-12 padding-0 margin-0">
                            <div class="col-lg-6" style="padding: 5px">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row col-lg-12 padding-0 margin-0 grid">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Grid')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                {!! Form::number('', null,['class' => 'form-control modal-input-grid','required' => true,'placeholder' => '1']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0 grid-padding">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Grid padding')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                {!! Form::number('', 0,['class' => 'form-control modal-input-grid-padding','required' => true,'placeholder' => '1']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Slider')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                <input type="checkbox" name="" class="toogle-switch modal-input-slider" value="1">
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0 slider-type">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Slider Type')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                {!! Form::select('',\App\Layout::LAYOUT_SLIDER_ARRAY, null,['class' => 'form-control modal-input-slider-type']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Text alig.')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                <span style="padding: 10px"><input type="radio" name="text_alignment" id="alignment-left" class="modal-input-alignment" value="left"> <label for="alignment-left">left</label></span>
                                                <span style="padding: 10px"><input type="radio" name="text_alignment" id="alignment-center" class="modal-input-alignment" value="center"> <label for="alignment-center">center</label></span>
                                                <span style="padding: 10px"><input type="radio" name="text_alignment" id="alignment-right" class="modal-input-alignment" value="right"> <label for="alignment-right">right</label></span>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Background')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                <span style="padding: 10px"><input type="radio" name="background_color" id="background-light" class="modal-input-background" value="0"> <label for="background-light">light</label></span>
                                                <span style="padding: 10px"><input type="radio" name="background_color" id="background-dark" class="modal-input-background" value="1"> <label for="background-dark">dark</label></span>
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Container')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                <input type="checkbox" name="" class="toogle-switch modal-input-container" value="1">
                                            </div>
                                        </div>
                                        <div class="form-group row col-lg-12 padding-0 margin-0 parallel">
                                            <div class="col-lg-3 d-flex align-items-center padding-0">{{__('Parallel')}}</div>
                                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                                <input type="checkbox" name="" class="toogle-switch modal-input-parallel" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="padding: 5px">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row col-lg-12 padding-0 margin-0" style="padding-bottom: 10px">
                                            <div class="col-lg-12 padding-0 margin-0">
                                                {!! Form::select('',\App\Layout::LAYOUT_MODELS_ARRAY, null,['class' => 'form-control modal-input-layout-model']) !!}
                                            </div>

                                            <div class="col-lg-12 modal-input-banner-section margin-0" style="padding: 10px 0px 0px 0px">
                                                <div class="col-lg-12 padding-0 margin-0 modal-input-banner-section">
                                                    {!! Form::select('',[null=>'No banners selected'] + \App\Banner::GROUP_ARRAY, null,['class' => 'form-control modal-input-banner-group']) !!}
                                                </div>
                                                <div class="loading-spinner" style="display: none">
                                                    <div class="row d-flex justify-content-center" style="padding-top: 20px;">
                                                        <div class="lds-dual-ring "></div>
                                                    </div>
                                                </div>
                                                <div style="padding-top: 10px">
                                                    <ul id="sortable" class="layout-item-banners">

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-12">
                            <button id="" type="submit" name="submit" class="btn btn-light btn-lg col-12 submit-layout-item" >{{__('Submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $(function () {
            /**
            * set up
            */
            $( ".layout-items" ).sortable();
            $( ".layout-item-banners" ).sortable();

            /**
             * Functions
             */
            // delete layout item
            function deleteLayoutItem() {
                $('.delete-layout-item').off('click');
                $('.delete-layout-item').click(function () {
                    if (!confirm('Are you sure you want to delete this item?')){
                        return false;
                    }
                    $(this).parent().parent().parent().remove();
                });
            }
            // Reset add item form
            function resetModalFields() {
                $('.modal-input-name').val('');
                $('.modal-input-description').val('');
                $('.modal-input-grid').val('');
                $('.modal-input-grid-padding').val(0);
                $('.modal-input-parallel').prop('checked',false);
                $('.modal-input-container').prop('checked',false);
                $('.modal-input-alignment:checked').prop('checked',false);
                $('.modal-input-background:checked').prop('checked',false);
                $('.modal-input-slider:checked').prop('checked',false);
                $('.modal-input-layout-model').val(1);
                $('.modal-input-slider-type').val(1);
                $('.modal-input-banner-group').val(null);
                $('.modal-input-banner-section').slideDown();
                $('.layout-item-banners').html('');
                $('.submit-layout-item').html('Submit');
                $('.modal-title').html('{{__('Add new item')}}');
            }
            // draw selected banners group list items
            function drawGroupBanners(selected_group_id, selected_items = null) {
                $.get('/manage/layouts/get/banners/'+selected_group_id)
                    .done(function (response) {
                        $('.loading-spinner').slideUp();
                        var banners = response.banners;
                        $('.layout-item-banners').html('');
                        $.each(banners, function( id, name ){
                            var new_item = $('.banner-template').clone().removeClass('banner-template').addClass('modal-input-banner-item').show();
                            new_item.find('.banner-input').val(id);
                            new_item.find('.banner-input').attr('id','banner-'+id);
                            if (selected_items != null && selected_items.includes(id)){
                                new_item.find('.banner-input').prop('checked',true);
                            } else {
                                new_item.find('.banner-input').prop('checked',false);
                            }
                            new_item.find('.banner-name').html(name);
                            new_item.find('.banner-name').attr('for','banner-'+id);
                            $('.layout-item-banners').append(new_item);
                        });
                    }).fail(function () {
                    $('.loading-spinner').slideUp();
                    $('.layout-item-banners').html('');
                });

            }
            // change layout model
            function updateModelRelatedFields(layout_model)
            {
                var layout_model_blog = '{{\App\Layout::LAYOUT_MODEL_BLOG}}';
                var layout_model_banner = '{{\App\Layout::LAYOUT_MODEL_BANNERS}}';
                if (layout_model === layout_model_banner){
                    $('.modal-input-banner-section').fadeIn();
                } else {
                    $('.modal-input-banner-section').fadeOut();

                }
            }
            // generate random item code
            function generateRandomString(length) {
                var text = "";
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for (var i = 0; i < length; i++)
                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                return text;
            }
            // edit layout item
            function editLayoutItem(){
                $('.edit-layout-item').off('click');
                $('.edit-layout-item').click(function () {
                    resetModalFields();
                    var code = $(this).attr('id');
                    var modal = $('#editLayoutItem');
                    var item = $('.banner-'+code);
                    $('.submit-layout-item').attr('id',code);

                    //
                    var modal_input_code = item.find("input[name='item_code[]']").val();
                    var modal_input_name = item.find("input[name='item_name[]']").val();
                    var modal_input_description = item.find("input[name='item_description[]']").val();
                    var modal_input_model = item.find("input[name='item_model[]']").val();
                    var modal_input_group = item.find("input[name='item_banner_group[]']").val();
                    var modal_input_grid = item.find("input[name='item_grid[]']").val();
                    var modal_input_grid_padding = item.find("input[name='item_grid_padding[]']").val();
                    var modal_input_parallel = item.find("input[name='item_parallel[]']").val();
                    var modal_input_alignment = item.find("input[name='item_alignment[]']").val();
                    var modal_input_background = item.find("input[name='item_background[]']").val();
                    var modal_input_slider = item.find("input[name='item_slider[]']").val();
                    var modal_input_slider_type = item.find("input[name='item_slider_type[]']").val();
                    var modal_input_container = item.find("input[name='item_container[]']").val();
                    $('.modal-input-name').val(modal_input_name);
                    $('.modal-input-description').val(modal_input_description);
                    $('.modal-input-layout-model').val(modal_input_model);
                    updateModelRelatedFields(modal_input_model);
                    $('.modal-input-banner-group').val(modal_input_group);
                    var model_input_banner_input = item.find("input[name='item_banners["+modal_input_code+"][]']")
                    var modal_input_banners_array = [];
                    model_input_banner_input.map(function () {
                        modal_input_banners_array.push($(this).val());
                    });
                    drawGroupBanners(modal_input_group, modal_input_banners_array);
                    $('.modal-input-grid').val(modal_input_grid);
                    $('.modal-input-grid-padding').val(modal_input_grid_padding);
                    if (modal_input_parallel === "1"){
                        $('.modal-input-parallel').prop('checked',true);
                    }
                    if (modal_input_container === "1"){
                        $('.modal-input-parallel').prop('checked',true);
                    }
                    $('.modal-input-background[value='+modal_input_background+']').prop("checked",true);
                    $('.modal-input-alignment[value='+modal_input_alignment+']').prop("checked",true);
                    if (modal_input_slider === "1"){
                        $('.modal-input-slider').prop('checked',true);
                    }
                    $('.modal-input-slider-type[value='+modal_input_slider_type+']').prop("selected",true); // TODO: need to confirm that this is working
                    if (modal_input_container === "1"){
                        $('.modal-input-container').prop('checked',true);
                    }
                    modal.find('.submit-layout-item').html('Update');

                    modal.find('.modal-title').html('Update item'+' ('+code+')');
                    modal.modal('show');
                });
            }
            // draw layout item
            function drawOrUpdateLayoutItem(method, id, modal_input_model_id, modal_input_name, modal_input_group, modal_input_container, modal_input_description, modal_input_grid, modal_input_grid_padding, modal_input_parallel, modal_input_alignment, modal_input_background, modal_input_model_title, modal_input_slider, modal_input_slider_type, modal_input_banners_array){
                if (id === ''){
                    var item_code = generateRandomString(6);
                    var item_class = 'banner-'+item_code;
                } else {
                    var item_code = id;
                    var item_class = 'banner-'+item_code;
                }
                if (method === 1){ // check if method to daw or to update
                    var layout_item = $('.item-template').clone().removeClass('item-template').addClass(item_class).show();
                } else {
                    var layout_item = $('.'+item_class);
                }
                var layout_banner_elements_data_field = layout_item.find('.layout-banner-elements-data-field');
                var layout_item_edit_layout_item = layout_item.find('.edit-layout-item');
                layout_banner_elements_data_field.html('');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_model[]" value="'+modal_input_model_id+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_model_name[]" value="'+modal_input_model_title+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_code[]" value="'+item_code+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_name[]" value="'+modal_input_name+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_description[]" value="'+modal_input_description+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_grid[]" value="'+modal_input_grid+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_grid_padding[]" value="'+modal_input_grid_padding+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_parallel[]" value="'+modal_input_parallel+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_alignment[]" value="'+modal_input_alignment+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_background[]" value="'+modal_input_background+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_banner_group[]" value="'+modal_input_group+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_container[]" value="'+modal_input_container+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_slider[]" value="'+modal_input_slider+'">\n');
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_slider_type[]" value="'+modal_input_slider_type+'">\n');
                //
                layout_item_edit_layout_item.attr('id', item_code);
                $.each(modal_input_banners_array, function (index, value) {
                        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_banners['+item_code+'][]" value="'+value+'">\n');
                });
                layout_item.find('.layout-item-name').html(modal_input_model_title+': '+modal_input_name);
                if (method === 1){ // check if method to daw or to update
                    $('.layout-items').append(layout_item);
                }
                deleteLayoutItem();
                editLayoutItem();

            }

            /**
             * Actions
             */
            // Add new item
            $('.add-layout-item').click(function () {
                resetModalFields();
                $('#editLayoutItem').modal('show');
            });

            // Change model type
            $('.modal-input-layout-model').change(function () {
                var layout_model = $(this).val();
                updateModelRelatedFields(layout_model);
            });

            // change banner type
            $('.modal-input-banner-group').change(function () {
                $('.loading-spinner').slideDown();
                var selected_group = $(this);
                // get banners with id
                drawGroupBanners(selected_group.val());

            });

            // submit form create / edit
            $('.submit-layout-item').click(function () {
                var id = $(this).attr('id'); // item code
                console.log(id);
                if (id === ''){
                    var method = 1; // draw
                } else {
                    var method = 2; // update
                }
                var modal_input_model_id = $('.modal-input-layout-model').val();
                var modal_input_name = $('.modal-input-name').val();
                var modal_input_group = $('.modal-input-banner-group').val();
                var modal_input_description = $('.modal-input-description').val();
                var modal_input_grid = $('.modal-input-grid').val();
                if (modal_input_grid === ''){
                    modal_input_grid = 1;
                }
                var modal_input_grid_padding = $('.modal-input-grid-padding').val();
                                if (modal_input_grid_padding === ''){
                                    modal_input_grid_padding = 0;
                                }

                var modal_input_alignment = $('.modal-input-alignment:checked').val();
                if (modal_input_alignment === undefined){
                    modal_input_alignment = 'center';
                }
                var modal_input_background = $('.modal-input-background:checked').val();
                if (modal_input_background === undefined){
                    modal_input_background = 0;
                }
                var model_input_banner_input = $('.modal-input-banner-item input:checked');
                var modal_input_model_title = $('.modal-input-layout-model').find(":selected").text();
                if ($('.modal-input-slider').prop('checked') === true) {
                    var modal_input_slider = 1;
                }else{
                    var modal_input_slider = 0;
                }
                if ($('.modal-input-container').prop('checked') === true) {
                    var modal_input_container = 1;
                }else{
                    var modal_input_container = 0;
                }
                if ($('.modal-input-parallel').prop('checked') === true) {
                    var modal_input_parallel = 1;
                }else{
                    var modal_input_parallel = 0;
                }
                var modal_input_slider_type = $('.modal-input-slider-type').val();
                var modal_input_banners_array = [];
                model_input_banner_input.map(function () {
                    modal_input_banners_array.push($(this).val());
                });
                if (modal_input_name === ''){
                    alert('Item name is required!');
                    return false;
                }
                drawOrUpdateLayoutItem(method, id, modal_input_model_id, modal_input_name, modal_input_group, modal_input_container, modal_input_description, modal_input_grid, modal_input_grid_padding, modal_input_parallel, modal_input_alignment, modal_input_background, modal_input_model_title, modal_input_slider, modal_input_slider_type, modal_input_banners_array);
                $('#editLayoutItem').modal('hide');
                resetModalFields();
            });

            // draw existing layout items
            @if (!empty($layout))
            // $('.no-items-yet').slideUp();
            $.get('{{ route('layout.get.structure', $layout->id) }}')
                .done(function (response) {
                    var items = response.structure;
                    items.map(function (item) {
                        var id = item.code; // item code
                        var modal_input_model_id = item.model;
                        var modal_input_name = item.name;
                        var modal_input_group = item.banner_group;
                        var modal_input_container = item.container;
                        var modal_input_description = item.description;
                        var modal_input_grid = item.grid;
                        var modal_input_grid_padding = item.grid_padding;
                        var modal_input_parallel = item.parallel;
                        var modal_input_alignment = item.text_alignment;
                        var modal_input_background = item.background;
                        var modal_input_model_title = item.model_name;
                        var modal_input_slider = item.slider;
                        var modal_input_slider_type = item.slider_type;
                        var modal_input_banners_array = item.item_banners;
                        var method = 1; // draw
                        drawOrUpdateLayoutItem(method, id, modal_input_model_id, modal_input_name, modal_input_group ,modal_input_container, modal_input_description, modal_input_grid, modal_input_grid_padding, modal_input_parallel, modal_input_alignment, modal_input_background, modal_input_model_title, modal_input_slider, modal_input_slider_type, modal_input_banners_array);

                    });
                });
            @endif

        });
    </script>
@endsection
