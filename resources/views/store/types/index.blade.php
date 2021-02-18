@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <button id="add_new_product_type" type="button" class="btn btn-primary btn-lg w-75" data-toggle="modal" data-target="#productTypeModal"><span class="fa fa-plus-circle" aria-hidden="true"></span>  <span>{{trans('main._add')}}</span></button>
@endsection
@section('content')
<section>
    {{--Page header--}}
    @include('manage.partials._page-header')

    {{--List of items--}}
    <div>
        <div class="card border-light table-card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Attribute Set')}}</th>
                        <th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($types as $item)
                        <tr>
                            <td class="align-middle">
                                <p>{{ucfirst($item->name)}}</p>
                                <p class="text-muted"><small> {{$item->created_at->toFormattedDateString()}}</small></p>
                                <p>{{substr(strip_tags($item->description),0,50)}} {{strlen($item->description) > 50 ? "...": "" }}</p>
                            </td>
                            <td class="align-middle">{{$item->attributeSet->name}}</td>
                            <td>
                                <div class="action_btn text-right" style="padding-top: 10px">
                                    <ul>
                                        <li class="">
                                            <span id="{{$item->id}}" class="btn btn-light edit-product-type" data-toggle="modal" data-target="#productTypeModal"><i class="far fa-edit"></i></span>
                                        </li>
                                        @if($item->id != 1)
                                        <li class="">
                                            <span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                            <form id="delete-form" method="post" action="{{route('store.types.destroy', $item->id)}}">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <div style="display: none">
                            <span class="product-type-{{$item->id}}-name">{{$item->name}}</span>
                            <span class="product-type-{{$item->id}}-description">{{$item->description}}</span>
                            <span class="product-type-{{$item->id}}-attribute-set">{{$item->product_attribute_set_id}}</span>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        {{$types->links()}}
    </div>
</section>
<section>
{{--Add or Edit type--}}
<!-- Button trigger modal -->
    <!-- Modal -->
    <form id="productTypeForm" method="POST" action="{{route('store.types.store')}}" enctype="multipart/form-data" data-parsley-validate>
        {{csrf_field()}}
        <div id="edit_field"></div>
        <div class="modal fade" id="productTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('New Product Type')}}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="text" name="name" class="form-control product-type-name" value="" placeholder="{{trans('main._title')}}" required>
                        </div>
                        <div class="form-group">
                            <textarea name="description" class="form-control product-type-description" placeholder="{{trans('main._description')}}  ...."></textarea>
                        </div>
                        <div class="form-group">
                            {!! Form::select('product_attribute_set_id',[null=>'-- Please Select Attribute Set--'] + $attribute_Sets, null,['class' => 'form-control product-type-attribute-set']) !!}
                        </div>

                        {{--          <div class="form-group row">--}}
                        {{--            <div class="col-md-3">{{trans('main._status')}}:</div>--}}
                        {{--            <div class="col-md-9 d-flex justify-content-start">--}}
                        {{--                <input type="checkbox" name="status" class="toogle-switch" value="1" checked>--}}
                        {{--            </div>--}}
                        {{--          </div>--}}
                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-12">
                            <button type="submit" name="submit" class="btn btn-light btn-lg col-12 form-submit" >{{__('submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
@section('script')
    <script>
        $('#add_new_product_type').click(function () {
            $('#exampleModalLabel').html('{{__('New Product Type')}}');
            $('.product-type-name').val('');
            $('.product-type-description').html('');
            $('.product-type-attribute-set').val('');
            $('#edit_field').append('');

        });
        // update category
        var form = $('#productTypeForm');
        var url = '{{url('')}}';
        $('.edit-product-type').click(function () {
            var item_id = $(this).attr('id');
            var item_title = $('.product-type-'+item_id+'-name').html();
            var item_description = $('.product-type-'+item_id+'-description').html();
            var item_attribute_set = $('.product-type-'+item_id+'-attribute-set').html();
            var action = url+'/manage/store/types/'+item_id;
            var put_field = '{{method_field('PUT')}}';

            form.attr('action',action);
            // var item_status = $('.category-'+item_id+'-status').html();
            $('#exampleModalLabel').html('{{__('Edit Product Type')}}');
            $('.product-type-name').val(item_title);
            $('.product-type-description').html(item_description);
            $('.product-type-attribute-set').val(item_attribute_set);
            $('#edit_field').append(put_field);
            // if (item_status === 1){
            // 	$('.category_status').prop('checked', true);
            // }
        });
    </script>
@endsection
