@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($field))
            {!! Form::open(['url' => route('institution.fields.update', [$scope->slug, $field->slug]),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('institution.fields.store', $scope->slug),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
            @include('manage.partials._page-header')
            <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Field Name')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('title',!empty($field) ? $field->title : null,['class' => 'form-control name','required' => true,'placeholder' => 'Field Name']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',!empty($field->description) ? $field->description : null,['class' => 'form-control','rows' => '5']) !!}
                            </div>
                        </div>
{{--                        <div class="form-group row col-lg-12">--}}
{{--                            <div class="col-lg-2 d-flex align-items-center">{{__('Type')}}</div>--}}
{{--                            <div class="col-lg-10 padding-0 margin-0">--}}
{{--                                {{ Form::select('type', $types, !empty($field) ? $field->type : null, ['id' => 'attribute_type', 'class' => 'form-control']) }}--}}
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
                                <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($field) || !empty($field->status) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Default')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="default" class="toogle-switch" value="1" {{!empty($field->default) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Levels')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <table class="table bg-white table-striped">
                                    <tr>
                                        <td style="width: 5%">No.</td>
                                        <td>Name</td>
                                        <td>Status</td>
                                        <td>Default</td>
                                    </tr>
                                    @for($i = 1 ; $i <=  6 ; $i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><input type="text" class="form-control" name="level_title[{{$i}}]" value="{{(!empty($field) && !empty($field->levels)) ? $field->levels[$i]['title'] : 'level '.$i}}"><input
                                                    type="hidden" name="level_id[{{$i}}]" value="{{$i}}"></td>
                                        <td><input type="checkbox" name="level_status[{{$i}}]" class="toogle-switch" value="1" {{(!empty($field) && !empty($field->levels) && $field->levels[$i]['status'] == 1) ? 'checked' : ''}}></td>
                                        <td><input id="item_default-{{$i}}" type="checkbox" name="level_default[{{$i}}]" class="toogle-switch level-default" value="1" {{(!empty($field) && !empty($field->levels) && $field->levels[$i]['default'] == 1) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                        <div id="type-radio" class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex">{{__('Field options')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div class="text-right">
                                    <span onclick="addOptionRow()" class="btn btn-primary">Add Option</span>
                                </div>
                                <br />
                                <table id="field-options-table" class="table bg-white table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Position</th>
                                        <th>Default</th>
                                        <th>Remove</th>
                                    </tr>
                                    @if (!empty($field))
                                        @foreach ($field->options as $option)
                                            <tr>
                                                <td><input name="option_title[]" type="text" class="form-control" placeholder="Name" value="{{$option->title}}"><input type="hidden" name="option_id[]" class="form-control" maxlength="191" value="{{$option->id}}"/></td>
                                                <td><input name="option_desc[]" type="text" class="form-control" placeholder="Description" value="{{$option->description}}"></td>
                                                <td><input name="option_position[]" type="text" class="form-control" value="{{$option->position}}"></td>
                                                <td><input id="option_default{{$option->id}}" type="checkbox" name="" class="toogle-switch default-toogle-switch" value="1" {{empty($option) || !empty($option->default) ? 'checked' : ''}}><input type='hidden' value='{{empty($option) || !empty($option->default) ? '1' : '0'}}' name='option_default[]' class="option_default_value"></td>
                                                <td><span id="{{$option->id}}" class="btn btn-outline-danger remove-option"><i class="far fa-trash-alt"></i></span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                                <script>

                                </script>
                            </div>
                        </div>
                        <div class="removed-items">
                        </div>
                        @if(!empty($scope))
                        {{ Form::hidden('scope_id', $scope->id) }}
                        {{ Form::hidden('scope_slug', $scope->slug) }}
                        @endif
                        <script>
                            // generate random item code
                            function generateRandomString(length) {
                                var text = "";
                                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                                for (var i = 0; i < length; i++)
                                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                                return text;
                            }
                            function removeOption(){
                                $('.remove-option').off('click');
                                $('.remove-option').click(function () {
                                    if(!confirm('Are you sure that you want to remove this item')){
                                        return false;
                                    }
                                    var option= $(this);
                                    var option_id = $(this).attr('id');
                                    if (option_id > 0) {
                                        $('.removed-items').append('' +
                                            '<input type="hidden" name="removed_options['+option_id+']" value="'+option_id+'">\n' +
                                            '');
                                    }
                                    option.parent().parent().remove();
                                });
                            }
                            function resetLevelDefault() {
                                $('.level-default').off('change');
                                $('.level-default').change(function () {
                                    // var item = $(this);
                                    var itemId = $(this).attr('id');
                                    $('.level-default').each(function( index ) {
                                        var levelId = $(this).attr('id');
                                        if (levelId !== itemId){
                                            $(this).prop("checked", false);
                                        }
                                    });
                                });
                            }
                            function resetOptionDefault() {
                                $('.default-toogle-switch').off('change');
                                $('.default-toogle-switch').change(function () {
                                    var item = $(this);
                                    if (item.is(":checked")){
                                        console.log('yes');
                                        item.parent().find('.option_default_value').val(1)
                                    }else {
                                        console.log('no');
                                        item.parent().find('.option_default_value').val(0)
                                    }
                                    var itemId = item.attr('id');
                                    $('.default-toogle-switch').each(function( index ) {
                                        var levelId = $(this).attr('id');
                                        if (levelId !== itemId){
                                            $(this).parent().find('.option_default_value').val(0)
                                            $(this).prop("checked", false);
                                        }
                                    });
                                })
                            }
                            function addOptionRow() {
                                // Find a <table> element with id="myTable":
                                var table = document.getElementById("field-options-table");
                                // Create an empty <tr> element and add it to the 1st position of the table:
                                var newRow = table.insertRow();
                                // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input name="option_title[]" type="text" class="form-control" placeholder="Name"><input type="hidden" name="option_id[]" class="form-control" maxlength="191" value=""/></td>';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input name="option_desc[]" type="text" class="form-control" placeholder="Description"></td>';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input name="option_position[]" type="text" class="form-control" value="0"></td>';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><input id="'+generateRandomString(4)+'" type="checkbox" name="" class="toogle-switch default-toogle-switch" value="1"><input type="hidden" value="0" name="option_default[]" class="option_default_value"></td>\n';
                                var newCell = newRow.insertCell();
                                newCell.innerHTML = '<td><span id="" class="btn btn-outline-danger remove-option"><i class="far fa-trash-alt"></i></span></td>';
                                removeOption();
                                resetOptionDefault();
                            }
                            removeOption();
                            resetLevelDefault();
                            resetOptionDefault();

                        </script>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </section>

@endsection