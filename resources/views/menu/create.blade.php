@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._new_post'))
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')

@section('head')
    <style>
        .layout-items{
            list-style: none;
        }
        .layout-items li{
            display: block;
            margin-bottom: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
            /*border-left: 2px solid #3399FF;*/
            border: 1px solid #2196F3;
            margin-left: -50px;
        }

        .add-item{
            margin-left: 10px;
            margin-right: 10px;
        }
        .layout .btn{
            min-width: 80px;
        }
    </style>
@endsection
<section>
    @if(!empty($menu))
        {!! Form::open(['url' => route('menus.update', $menu->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
    @else
        {!! Form::open(['url' => route('menus.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
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
                            {!! Form::text('title',!empty($menu) ? $menu->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2 d-flex align-items-center">{{__('Position')}}</div>
                        <div class="col-lg-5 padding-0 margin-0">
                            {!! Form::select('category_id',[null=>'-- Please select menu position --'] + $positions,!empty($menu) ? $menu->position : null,['class' => 'form-control']) !!}
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
                    <div class="form-group row col-lg-12 d-flex justify-content-end margin-0" style="padding:10px 5px"><span class="btn btn-outline-secondary add-item" style=""><i class="fas fa-plus-circle"></i> {{__('Add Item')}}</span></div>
                    <div class="form-group row col-lg-12">
                        <div class="col-lg-2">{{__('Menu Items')}}</div>
                        <div class="col-lg-10 padding-0 margin-0">
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

</section>
<section style="display: none">
{{--template--}}
    <li class="item-template" style="display: none; background-color: white">
        <div class="row col-lg-12">
            <div class="col-lg-5 d-flex align-items-center">
                <input type="text" name="item-title[]" class="form-control item-title" placeholder="Menu title">
            </div>
            <div class="col-lg-5 d-flex align-items-center">
                <input type="text" name="item-link[]" class="form-control item-link" placeholder="Link url">
            </div>
            <div class="col-lg-2 text-right">
                <span class="btn btn-light"><i class="far fa-plus-square"></i></span>
                <span class="btn btn-light delete-layout-item"><i class="far fa-trash-alt"></i></span>
            </div>
        </div>
    </li>
</section>
@endsection
@section('script')
    <script>
        $( ".layout-items" ).sortable();
        $( document ).ready(function() {
            function deleteLayoutItem() {
                $('.delete-layout-item').click(function () {
                    $(this).parent().parent().parent().remove();
                });
            }
            $('.add-item').click(function () {
                console.log('clicked');
                // $('.no-items-yet').slideUp();
                var item = $('.item-template').clone().removeClass('item-template').show();
                // item.find('.bg-dark-input').attr('id','bg-dark-color-item-'+count);
                $('.layout-items').append(item);
                // count++;
                deleteLayoutItem();
            });
            var count = 1;
            function drawMenuItems(structure) {
                structure.map(function (item) {
                    var new_item = $('.item-template').clone().removeClass('item-template').show();
                    new_item.find('.item-title').val(item.title);
                    new_item.find('.item-link').val(item.link);
                    $('.layout-items').append(new_item);
                    count++;
                });
                deleteLayoutItem();
            }
            @if (!empty($menu))
            // $('.no-items-yet').slideUp();
            $.get('{{ route('menu.get.structure', $menu->id) }}')
                .done(function (response) {
                    drawMenuItems(response.structure);
                });
            @endif
        });

    </script>
@endsection
