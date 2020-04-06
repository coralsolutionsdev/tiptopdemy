@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)

@section('page-header-button')
    <a href="{{Route('languages.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('content')

<section>
    {{--Page header--}}
    @include('manage.partials._page-header')

    {{--List of items--}}
    <div class="form-panel row">
        <div class="col-lg-12">
            <div class="card border-light">
                <div class="card-body">
                    <p>{{__('Available Languages')}}</p>
                    <hr>
                    <div class="row col-lg-12" style="padding-top: 10px">
                        <table id="languages-table" class="table bg-white table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Position</th>
                                <th>Status</th>
                            </tr>
                            @if (!empty($languages))
                                @foreach ($languages as $lang)
                                    <tr>
                                        <td>
                                            {{$lang->name}}
                                        </td>
                                        <td>
                                            {{$lang->code}}
                                        </td>
                                        <td>
                                            {{$lang->position}}
                                        </td>
                                        <td class="text-center align-middle">{!! getStatusIcon($lang->status) !!}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
    {{--List of terms--}}
    <div class="form-panel row">
    <div class="col-lg-12">
        <div class="card border-light">
            <div class="card-body">
                <p>{{__('Language\'s items')}}</p>
                <hr>
                <div class="row" style="padding: 0px 10px">
                    <button class="btn btn-outline-primary add-language-key" onclick="addLanguageKey()">Add key</button>
                </div>
                {!! Form::open(['url' => route('update.language.keys'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}

                <div class="languages-keys" style="padding: 10px">
                    <div class="row" style="padding: 5px 0px; background-color: #F3F5F9">
                        <div class="col-2">key</div>
                        @if (!empty($languages))
                            @foreach($languages as $language)
                                <div class="col-2">{{$language->name}} ({{$language->code}})</div>
                            @endforeach
                        @endif
                        <div class="col-1">Delete</div>
                    </div>
                    @foreach($LanguageKys as $key => $langKeys)
                        <div class="row" style="padding: 5px">
                            <div class="col-2" style="padding:1px 5px"><input type="text" name="key[]" class="form-control" value="{{$key}}" required></div>
                                @foreach($langKeys as $lang => $trans)
                                <div class="col-2" style="padding:1px 5px"><input type="text" name="trans[][{{$language->code}}]" class="form-control" value="{{$trans}}" required></div>
                                @endforeach
                            <div class="col-1"><span class="btn btn-outline-danger delete-lang-key"><i class="far fa-trash-alt"></i></span></div>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary">
                    update
                </button>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
    <section>
        <div class="row key-row-template" style="padding: 5px; display: none">
            <div class="col-2" style="padding:1px 5px"><input type="text" name="key[]" class="form-control" required></div>
            @if (!empty($languages))
                @foreach($languages as $language)
                    <div class="col-2" style="padding:1px 5px"><input type="text" name="trans[][{{$language->code}}]" class="form-control" required></div>
                @endforeach
            @endif
            <div class="col-1"><span class="btn btn-outline-danger delete-lang-key"><i class="far fa-trash-alt"></i></span></div>
        </div>
    </section>
    </div>
</section>

<script>

    function removeItem(){
        $('.delete-lang-key').off('click');
        $('.delete-lang-key').click(function () {
            if(!confirm('Are you sure that you want to remove this item')){
                return false;
            }
            var item = $(this);
            $(this).parent().parent().remove();
        });
    }
    removeItem();

    /**
     * methods
     */
    function addLanguageKey() {
        var newItem = $('.key-row-template').clone().removeClass('key-row-template').show();
        $('.languages-keys').append(newItem);
        removeItem();
    }
    function addOptionRow() {
        // Find a <table> element with id="myTable":
        var table = document.getElementById("languages-table");
        // Create an empty <tr> element and add it to the 1st position of the table:
        var newRow = table.insertRow();
        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        var newCell = newRow.insertCell();
        newCell.innerHTML = '<td><input name="added_name[]" type="text" class="form-control" placeholder="Name"><input type="hidden" name="added_id[]" class="form-control" maxlength="191" value=""/></td>';
        var newCell = newRow.insertCell();
        newCell.innerHTML = '<td><input name="added_code[]" type="text" class="form-control" placeholder="Code: EN" disabled></td>';
        var newCell = newRow.insertCell();
        newCell.innerHTML = '<td><input name="added_position[]" type="text" class="form-control" value="0"></td>';
        var newCell = newRow.insertCell();
        newCell.innerHTML = '<td><span id="" class="btn btn-outline-danger remove-item"><i class="far fa-trash-alt"></i></span></td>';
        removeItem();
    }

</script>

@endsection