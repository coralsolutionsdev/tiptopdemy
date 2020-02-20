@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($attribute))
            {!! Form::open(['url' => route('store.attributes.update', [$set->id, $attribute->id]),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('store.attributes.store', $set->id),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header')
        <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Set Name')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('name',!empty($attribute) ? $attribute->name : null,['class' => 'form-control name','required' => true,'placeholder' => 'Set Name']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',!empty($attribute->description) ? $attribute->content : null,['class' => 'form-control','rows' => '5']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('position')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('position', 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
{{--                        @if (empty($attribute) || $attribute->type == \App\ProductAttribute::TYPE_TEXT_FIELD)--}}
{{--                            <div id="default_value" class="form-group {{ $errors->has('default') ? 'has-error' : '' }}">--}}
{{--                                <label class="col-sm-2 control-label">Default Value</label>--}}

{{--                                <div class="col-sm-10">--}}
{{--                                    {!! Form::text('default', null, ['class' => 'form-control', 'placeholder' => 'Optional']) !!}--}}
{{--                                    {!! $errors->first('position', '<span class="help-block">:message</span>') !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Show on Frontend')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="show_on_frontend" class="toogle-switch" value="1" {{empty($attribute) || !empty($attribute->show_on_frontend) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Used for Filters')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="filterable" class="toogle-switch" value="1" {{empty($attribute) || !empty($attribute->filterable) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Show on Edit')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="show_on_edit" class="toogle-switch" value="1" {{empty($attribute) || !empty($attribute->show_on_edit) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Type')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {{ Form::select('type', $types, !empty($attribute) ? $attribute->type : null, ['id' => 'attribute_type', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div id="type-radio" class="form-group row col-lg-12 additional-data">
                            <div class="col-lg-2 d-flex">{{__('Attribute Options')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div class="text-right">
                                    <span onclick="addRadioRow()" class="btn btn-primary">Add Option</span>
                                    <span onclick="removeRadioDefault()" class="btn btn-default">Remove Default</span>
                                </div>
                                <br />
                                <table id="type-radio-table" class="table bg-white table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Value</th>
                                        <th>Position</th>
                                        <th>Default</th>
                                        <th>Remove</th>
                                    </tr>
                                    @if (!empty($attribute))
                                        @foreach ($attribute->options as $option)
                                            <tr>
                                                <input type='hidden' name='radio_id[]' class='form-control' maxlength='191' value="{{ $option->id }}"/>
                                                <td><input type='text' name='radio_name[]' class='form-control' maxlength='191' value="{{ $option->name }}"/></td>
                                                <td><input type='text' name='radio_value[]' class='form-control' maxlength='191' value="{{ $option->value }}"/></td>
                                                <td><input type='text' name='radio_position[]' class='form-control' maxlength='191' value="{{ $option->position }}"/></td>
                                                <td><input type='radio' name='radio_default' maxlength='191' value="{{ $loop->index }}" {{ $option->is_default ? 'checked' : '' }}/></td>
                                                <td><span id="{{$option->id}}" class="btn btn-outline-danger remove-option"><i class="far fa-trash-alt"></i></span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="removed-items">
                        </div>

                        {{ Form::hidden('product_attribute_set_id', $set->id) }}

                        <script type="text/javascript">
                            function removeAttributeOption(){
                                $('.remove-option').click(function () {
                                    var option= $(this);
                                    var option_id = $(this).attr('id');
                                    if (option_id > 0) {
                                        $('.removed-items').append('' +
                                            '<input type="hidden" name="removed-options['+option_id+']" value="'+option_id+'">\n' +
                                            '');
                                    }
                                    option.parent().parent().remove();

                                });
                            }
                            removeAttributeOption();

                            $('.additional-data').hide();
                            @if (!empty($attribute) && ($attribute->type == \App\ProductAttribute::TYPE_RADIO || $attribute->type == \App\ProductAttribute::TYPE_CHECKBOX || $attribute->type == \App\ProductAttribute::TYPE_COLOR))
                            $('#type-radio').show();
                            @endif
                            $('#attribute_type').change(function() {
                                if (this.value != {{ \App\ProductAttribute::TYPE_TEXT_FIELD }}) {
                                    $('#default_value').fadeOut();
                                } else {
                                    $('#default_value').fadeIn();
                                }
                                $('.additional-data').fadeOut();
                                if (this.value == {{ \App\ProductAttribute::TYPE_RADIO }} || this.value == {{ \App\ProductAttribute::TYPE_CHECKBOX }} || this.value == {{ \App\ProductAttribute::TYPE_COLOR }}) {
                                    $('#type-radio').fadeIn();
                                }

                            });

                            function addRadioRow() {
                                var newRow = document.getElementById('type-radio-table').insertRow();
                                var optionId = $('#type-radio-table tr').length - 2;

                                var newCell = newRow.insertCell();
                                newCell.innerHTML="<tr><td><input type='text' data-radio-option-id='" + optionId +"' name='radio_name[]' class='form-control' maxlength='191'></td></tr>";

                                newCell = newRow.insertCell();
                                newCell.innerHTML="<tr><td><input type='text' name='radio_value[]' placeholder='Optional' class='form-control'  maxlength='191' /></td></tr>";

                                newCell = newRow.insertCell();
                                newCell.innerHTML="<tr><td><input type='text' class='form-control' class='form-control' maxlength='191' value='" + optionId +"' name='radio_position[]'></td></tr>";

                                newCell = newRow.insertCell();
                                newCell.innerHTML="<tr><td><input type='radio' name='radio_default' value='" + optionId + "'></td></tr>";
                                newCell = newRow.insertCell();
                                newCell.innerHTML="<td><span id='' class='btn btn-outline-danger remove-option'><i class='far fa-trash-alt'></i></span></td>";
                                removeAttributeOption();

                            }

                            function removeRadioRow() {
                                $('#type-radio-table tr').last().remove();
                            }

                            function removeRadioDefault() {
                                $('input[name=radio_default]').prop('checked', false);
                            }



                        </script>

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </section>

@endsection
@section('script')

@endsection
