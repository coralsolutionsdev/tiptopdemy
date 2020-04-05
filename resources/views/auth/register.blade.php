@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'register')
@section('head')
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>--}}
{{--    <script src="{{asset('/plugins/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>--}}
{{--    <link rel="stylesheet" href="{{url('/plugins/date_picker/css/bootstrap-datetimepicker.min.css')}}">--}}

@endsection
@section('content')
    <section>
        <div class="pt-25" style="background-color: #F3F5F9">
            <div class="uk-container">
                <div class="uk-flex uk-flex-center uk-padding-small" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m register-card">
                        <h3 class="uk-card-title">{{__('Register')}}</h3>

                        <form class="uk-form-stacked " role="form" method="POST" action="{{ route('register') }}" autocomplete="on">
                            {{ csrf_field() }}
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Full name')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-4@s">
                                            <input class="uk-input {{ $errors->has('first_name') ? ' uk-form-danger' : '' }}" name="first_name" type="text" placeholder="{{__('First name')}}" value="{{ old('first_name') }}" required>
                                        </div>
                                        <div class="uk-width-1-4@s">
                                            <input class="uk-input {{ $errors->has('middle_name') ? ' uk-form-danger' : '' }}" name="middle_name" type="text" placeholder="{{__('Father\'s name')}}" value="{{ old('middle_name') }}">
                                        </div>
                                        <div class="uk-width-1-4@s">
                                            <input class="uk-input {{ $errors->has('last_name') ? ' uk-form-danger' : '' }}" name="last_name" type="text" placeholder="{{__('Grandpa\'s name')}}" value="{{ old('last_name') }}">
                                        </div>
                                        <div class="uk-width-1-4@s">
                                            <input class="uk-input {{ $errors->has('surname') ? ' uk-form-danger' : '' }}" name="surname" type="text" placeholder="{{__('Surname')}}" value="{{ old('surname') }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Mother name')}}:</label>
                                <div class="uk-form-controls">
                                    <input class="uk-input {{ $errors->has('mother_name') ? ' uk-form-danger' : '' }}" name="mother_name" type="text" value="{{ old('mother_name') }}">
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Email')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: mail"></span>
                                        <input class="uk-input {{ $errors->has('email') ? ' uk-form-danger' : '' }}" name="email" type="text" placeholder="email@example.com" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Password')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                        <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" type="password" name="password" placeholder="{{__('Password')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <div class="uk-form-controls">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                        <input class="uk-input {{ $errors->has('password_confirmation') ? ' uk-form-danger' : '' }}" type="password" name="password_confirmation" placeholder="{{__('Password confirm')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Birthday')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                                        <input class="uk-input {{ $errors->has('birth_date') ? ' uk-form-danger' : '' }} birthday" type="text" name="birth_date" placeholder="{{__('Tap to select')}}" value="{{ old('birth_date') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Phone number')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-inline uk-width-1-1 disable-number-row">
                                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: phone"></span>
                                        <input class="uk-input {{ $errors->has('phone_number') ? ' uk-form-danger' : '' }}" name="phone_number" type="number" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Directorates')}}:</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" name="directorate_id" required>
                                        <option selected="true" disabled="disabled">Please select</option>
                                        @foreach(getCountryDirectorates() as $directorate)
                                        <option value="{{$directorate->id}}">{{$directorate->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('School kind')}}:</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select scope-items" name="scope_id" required>
                                        <option selected="true" disabled="disabled">Please select</option>
                                        @foreach(getCountryScopes() as $scope)
                                            <option value="{{$scope->id}}">{{$scope->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="uk-margin-small fields-section" style="display: none">
                                <label class="uk-form-label" for="">{{__('Study type')}}:</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select fields-items" name="field_id">

                                    </select>
                                </div>
                            </div>
                            <div class="uk-margin-small fields-items-section" style="display: none">
                                <div class="uk-form-controls">
                                    <select class="uk-select field-item-options" name="field_option_id">

                                    </select>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('School level')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: move"></span>
                                        <input class="uk-input {{ $errors->has('level') ? ' uk-form-danger' : '' }}" name="level" type="number" max="6" min="1" value="{{ old('level') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-small">
                                <label class="uk-form-label" for="">{{__('Gender')}}:</label>
                                <div class="uk-form-controls">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-6@s">
                                            <label><input class="uk-radio" type="radio" name="gender" value="1" checked> {{__('Male')}}</label>
                                        </div>
                                        <div class="uk-width-1-6@s">
                                            <label><input class="uk-radio" type="radio" name="gender" value="0"> {{__('Female')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <div>
                                <button class="uk-button uk-button-primary uk-width-1-1" style="background-color: #3B5998"><span class="uk-margin-small-right" uk-icon="facebook"></span> Facebook</button>
                            </div>
                            <div>
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
        $(".birthday").flatpickr();
        $('.scope-items').change(function () {
            var id = $(this).val();
            toggleScreenSpinner(true);
            $.get('/get/institution/scope/'+id+'/fields').done(function (response) {
                var fields = response.items;
                $('.fields-items').html('');
                $('.fields-items').append('<option selected="true" disabled="disabled">Please select</option>');
                if(fields.length !== 0){
                    $.each(fields,  function (id, name) {
                        $('.fields-items').append('<option value="'+id+'">'+name+'</option>');
                    });
                    $('.fields-section').slideDown();
                    toggleScreenSpinner(false);
                } else {
                    $('.fields-section').slideUp();
                    $('.fields-items-section').slideUp();
                    toggleScreenSpinner(false);
                }
            });
        });
        $('.fields-items').change(function () {
            var id = $(this).val();
            toggleScreenSpinner(true);
            $.get('/get/institution/scope/field/'+id+'/options').done(function (response) {
                var fields = response.items;
                $('.field-item-options').html('');
                $('.field-item-options').append('<option selected="true" disabled="disabled">Please select</option>');
                if(fields.length !== 0){
                    $.each(fields,  function (id, name) {
                        $('.field-item-options').append('<option value="'+id+'">'+name+'</option>');
                    });
                    $('.fields-items-section').slideDown();
                    toggleScreenSpinner(false);
                } else {
                    $('.fields-items-section').slideUp();
                    toggleScreenSpinner(false);
                }
            });
        });
        // function updateFieldOptionsMenu() {
        //     var id = $(this).val();
        //     // alert(id);
        // }
    </script>
@endsection
