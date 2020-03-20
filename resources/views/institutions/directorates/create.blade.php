@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($directorate))
            {!! Form::open(['url' => route('institution.directorates.update', $directorate->slug),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('institution.directorates.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
            @include('manage.partials._page-header')
            <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Directorate Name')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('title',!empty($directorate) ? $directorate->title : null,['class' => 'form-control name','required' => true,'placeholder' => 'Directorate Name']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',!empty($directorate->description) ? $directorate->description : null,['class' => 'form-control','rows' => '5']) !!}
                            </div>
                        </div>
{{--                        <div class="form-group row col-lg-12">--}}
{{--                            <div class="col-lg-2 d-flex align-items-center">{{__('Type')}}</div>--}}
{{--                            <div class="col-lg-10 padding-0 margin-0">--}}
{{--                                {{ Form::select('type', $types, !empty($directorate) ? $directorate->type : null, ['id' => 'attribute_type', 'class' => 'form-control']) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('position')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('position', 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($directorate) || !empty($directorate->status) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div id="type-radio" class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex">{{__('Directorate Items')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div class="text-right">
                                    <span onclick="addOptionRow()" class="btn btn-primary">Add Item</span>
                                </div>
                                <br />
                                <table id="field-options-table" class="table bg-white table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Position</th>
                                        <th>Remove</th>
                                    </tr>
                                    @if (!empty($directorate) && !empty($directorate->items))
                                        @foreach ($directorate->items as $option)
                                            <tr>
                                                <td><input name="item_title[]" type="text" class="form-control" placeholder="Name" value="{{$option['title']}}"><input type="hidden" name="item_id[]" class="form-control" maxlength="191" value="{{$option['id']}}"/></td>
                                                <td><input name="item_desc[]" type="text" class="form-control" placeholder="Description" value="{{$option['description']}}"></td>
                                                <td><input name="item_position[]" type="text" class="form-control" value="{{$option['position']}}"></td>
                                                <td><span id="{{$option['id']}}" class="btn btn-outline-danger remove-option"><i class="far fa-trash-alt"></i></span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="removed-items">
                        </div>
                        <script>
                            function removeOption(){
                                $('.remove-option').off('click');
                                $('.remove-option').click(function () {
                                    if(!confirm('Are you sure that you want to remove this item')){
                                        return false;
                                    }
                                    var option= $(this);
                                    var item_id = $(this).attr('id');
                                    if (item_id > 0) {
                                        $('.removed-items').append('' +
                                            '<input type="hidden" name="removed_items['+item_id+']" value="'+item_id+'">\n' +
                                            '');
                                    }
                                    option.parent().parent().remove();
                                });
                            }
                            removeOption();
                            function addOptionRow() {
                                // Find a <table> element with id="myTable":
                                var table = document.getElementById("field-options-table");
                                // Create an empty <tr> element and add it to the 1st position of the table:
                                var newRow = table.insertRow();
                                // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input name="item_title[]" type="text" class="form-control" placeholder="Name"><input type="hidden" name="item_id[]" class="form-control" maxlength="191" value=""/></td>';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input name="item_desc[]" type="text" class="form-control" placeholder="Description"></td>';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input name="item_position[]" type="text" class="form-control" value="0"></td>';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><span id="" class="btn btn-outline-danger remove-option"><i class="far fa-trash-alt"></i></span></td>';
                                removeOption();
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </section>

@endsection