@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'register')
@section('head')
@endsection
@section('content')
    <section>
        <div class="pt-25" style="background-color: #F3F5F9">
            <div class="uk-container">
                <div class="uk-flex uk-flex-center uk-padding-small" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-3-5@m register-card">
                        <h3 class="uk-card-title">{{__('Register')}}</h3>

                        <form class="uk-form-stacked " role="form" method="POST" action="{{ route('register') }}" autocomplete="on">
                            {{ csrf_field() }}
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Full name')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-1-4@m">
                                                <input class="uk-input {{ $errors->has('first_name') ? ' uk-form-danger' : '' }}" name="first_name" type="text" placeholder="{{__('First name')}}" value="{{ old('first_name') }}" required>
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <input class="uk-input {{ $errors->has('middle_name') ? ' uk-form-danger' : '' }}" name="middle_name" type="text" placeholder="{{__('Father\'s name')}}" value="{{ old('middle_name') }}">
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <input class="uk-input {{ $errors->has('last_name') ? ' uk-form-danger' : '' }}" name="last_name" type="text" placeholder="{{__('Grandpa\'s name')}}" value="{{ old('last_name') }}">
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <input class="uk-input {{ $errors->has('surname') ? ' uk-form-danger' : '' }}" name="surname" type="text" placeholder="{{__('Surname')}}" value="{{ old('surname') }}" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Email')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: mail"></span>
                                                <input class="uk-input {{ $errors->has('email') ? ' uk-form-danger' : '' }}" name="email" type="text" placeholder="your_email@example.com" value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Password')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-2">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" type="password" name="password" placeholder="{{__('Password')}}" required>
                                            </div>
                                            <div class="uk-inline uk-width-1-2">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input {{ $errors->has('password_confirmation') ? ' uk-form-danger' : '' }}" type="password" name="password_confirmation" placeholder="{{__('Password confirm')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('country')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-1-2@m">
                                                <select class="uk-select countries-items" name="country_id" required>
                                                    <option selected="true" disabled="disabled">{{__('Select study kind')}}</option>
                                                    @foreach(getCountries() as $country)
                                                        <option value="{{$country->id}}" {{$country->id == 368 ? 'selected' : ''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="uk-width-1-2@m">
                                                <div class="uk-form-controls directorates-section">
                                                    <select class="uk-select directorates-items" name="directorate_id" required>
                                                        <option selected="true" disabled="disabled">{{__('Select directorate')}}</option>
                                                        @foreach(getCountryDirectorates(368) as $item)
                                                        <option value="{{$item->id}}" {{$item->default == 1 ? 'selected' : ''}}>{{$item->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Study kind')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-1-4@m">
                                                <select class="uk-select scope" name="scope_id" required>
                                                    <option selected="true" disabled="disabled">Study kind</option>
                                                    @foreach(getInstitutionScopes() as $scope)
                                                        <option value="{{$scope->id}}" {{$scope->default == 1 ? 'selected' : ''}}>{{$scope->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <div class="uk-form-controls fields-section">
                                                    <select class="uk-select fields-items fields" name="field_id">
                                                        <option selected="true" disabled="disabled">Study field</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <div class="uk-form-controls">
                                                    <select class="uk-select field-level-options" name="level">
                                                        <option selected="true" disabled="disabled">Study level</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <div class="uk-form-controls fields-items-section">
                                                    <select class="uk-select field-item-options" name="field_option_id">
                                                        <option selected="true" disabled="disabled">Study type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Birthday')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-2-3@m">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                                                <input class="uk-input {{ $errors->has('birth_date') ? ' uk-form-danger' : '' }} birthday" type="text" name="birth_date" placeholder="{{__('Tap to select')}}" value="{{ old('birth_date') }}" required>
                                            </div>
                                            <div class="uk-width-1-3@m">
                                                <div class="uk-form-controls">
                                                    <div class="uk-grid-small" uk-grid style="padding-top: 10px">
                                                        <div class="uk-width-1-2@s">
                                                            <label><input class="uk-radio" type="radio" name="gender" value="1" checked> {{__('Male')}}</label>
                                                        </div>
                                                        <div class="uk-width-1-2@s">
                                                            <label><input class="uk-radio" type="radio" name="gender" value="0"> {{__('Female')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Phone number')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: phone"></span>
                                                <input class="uk-input {{ $errors->has('phone_number') ? ' uk-form-danger' : '' }}" name="phone_number" type="text" value="{{ old('phone_number') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(false)
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Mother name')}}:</label>
                                <div class="uk-form-controls">
                                    <input class="uk-input {{ $errors->has('mother_name') ? ' uk-form-danger' : '' }}" name="mother_name" type="text" value="{{ old('mother_name') }}">
                                </div>
                            </div>
                            @endif
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <button class="uk-button uk-button-primary uk-width-1-1">{{__('Register')}}</button>
                                </div>
                            </div>
                        </form>
                        <div class="uk-text-center" style="padding-bottom: 15px">
                            Or, register with..
                        </div>
                        <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
                            <div class="disabled-div">
                                <button class="uk-button uk-button-primary uk-width-1-1" style="background-color: #3B5998"><span class="uk-margin-small-right" uk-icon="facebook"></span> Facebook</button>
                            </div>
                            <div class="disabled-div">
                                <a href="{{route('login.socialite','google')}}" class="uk-button uk-button-primary uk-width-1-1" style="background-color: #D34836"><span class="uk-margin-small-right" uk-icon="google"></span> Google</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // initials
        $(".birthday").flatpickr();
        /**
         * functions
         */
        function resetFieldOptions() {
            $('.field-item-options').html('');
            $('.field-item-options').append('<option selected="true" disabled="disabled">{{__('Study type')}}</option>');
        }
        function resetFieldLevels() {
            $('.field-level-options').html('');
            $('.field-level-options').append('<option selected="true" disabled="disabled">{{__('Study Level')}}</option>');
        }
        function updateFieldLevelsMenu(id) {
            $.get('/get/institution/scope/field/'+id+'/levels').done(function (response) {
                var levels = response.items;
                console.log(levels);
                resetFieldLevels();
                if (levels !== undefined){
                    if(levels.length != 0){
                        $.each(levels, function (id, level) {
                            var selected = '';
                            if (level.status === 1){
                                if (level.default === 1){
                                    selected = 'selected';
                                }
                                $('.field-level-options').append('<option value="'+id+'" '+selected+'>'+level.title+'</option>');
                            }
                        });
                        // done
                    }
                }
                updateFieldOptionsMenu(id);
            });
        }
        function updateFieldOptionsMenu(id) {
            $.get('/get/institution/scope/field/'+id+'/options').done(function (response) {
                var items = response.items;
                    resetFieldOptions();
                    if(items.length !== 0){
                    $.each(items,  function (id, option) {
                        var selected = '';
                        if (option.default == 1){
                            selected = 'selected';
                        }
                        $('.field-item-options').append('<option value="'+option.id+'" '+selected+'>'+option.title+'</option>');
                    }).done(function () {
                        toggleScreenSpinner(false);
                    });
                    // done
                    } else {
                    // field
                    }
            });
            toggleScreenSpinner(false);

        }

        function updateFieldsMenu(id){
            $.get('/get/institution/scope/'+id+'/fields').done(function (response) {
                var fields = response.items;
                $('.fields-items').html('');
                $('.fields-items').append('<option selected="true" disabled="disabled">{{__('Study field')}}</option>');
                if(fields.length !== 0){
                    var defaultFieldId = null;
                    var levels = null;
                    $.each(fields,  function (id, field) {
                        var selected = '';
                        if (field.default == 1){
                            selected = 'selected';
                            defaultFieldId = field.id;
                            levels = field.levels;
                        }
                        $('.fields-items').append('<option value="'+field.id+'" '+selected+'>'+field.title+'</option>');
                    });

                    if (defaultFieldId !== null){
                        // update levels
                        updateFieldLevelsMenu(defaultFieldId);

                    }else{
                        // reset levels
                        resetFieldLevels();
                        // reset options
                        resetFieldOptions();
                    }

                }
                // done
                toggleScreenSpinner(false);
            });

        }
        /**
         * methods
         */


        $('.scope').change(function () {
            var id = $(this).val();
            toggleScreenSpinner(true);
            updateFieldsMenu(id);
        });

        $('.fields').change(function () {
            var id = $(this).val();
            toggleScreenSpinner(true);
            // update levels
            updateFieldLevelsMenu(id);
        });

        $( document ).ready(function() {
            var id = $('.scope').val();
            toggleScreenSpinner(true);
            updateFieldsMenu(id);
        });


    </script>
@endsection
