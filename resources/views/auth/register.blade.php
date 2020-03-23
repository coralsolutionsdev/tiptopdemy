@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'register')
@section('head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>
    <script src="{{asset('/plugins/date_picker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('/plugins/date_picker/css/bootstrap-datetimepicker.min.css')}}">

@endsection
@section('content')
    <section>
        <div class="pt-25" style="background-color: #F3F5F9" uk-height-viewport="expand: true">
            <div class="uk-container">
                <div class="uk-flex uk-flex-center uk-padding-small" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-3-5@m">
                        @if(getSite()->registration == 0)
                            <div class="uk-text-center">
                                <h1 class=" mytext-light"><span class="uk-text-danger" uk-icon="icon: ban; ratio: 3.5"></span></i>
                                </h1>
                                <h3>{{trans('main._reg_not_allowed')}}</h3>
                                <p>{{trans('main._for_more_info')}} <a href="{{route('contact')}}">{{trans('main._here')}}</a></p>
                            </div>
                        @else
                        <h3 class="uk-card-title">{{__('Register')}}</h3>
                            <form class="uk-form-stacked" role="form" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <div>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Name')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-width-1-4@s">
                                                <input class="uk-input" type="text" placeholder="{{__('First name')}}">
                                            </div>
                                            <div class="uk-width-1-4@s">
                                                <input class="uk-input" type="text" placeholder="{{__('Father\'s name')}}">
                                            </div>
                                            <div class="uk-width-1-4@s">
                                                <input class="uk-input" type="text" placeholder="{{__('Grandpa name')}}">
                                            </div>
                                            <div class="uk-width-1-4@s">
                                                <input class="uk-input" type="text" placeholder="{{__('Surname')}}">
                                            </div>
                                        </div>
                                    </div>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Mother\'s name:')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-width-1-1@s">
                                                <input class="uk-input" type="text" placeholder="{{__('Full name')}}">
                                            </div>
                                        </div>
                                    </div>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Email:')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-width-1-1@s">
                                                <input class="uk-input" id="form-stacked-text" name="email" type="text" placeholder="Email" value="{{!empty($email) ? $email : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Password:')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-1@s">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input" id="form-stacked-text" type="password" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                    </div>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Confirm pass.:')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-1@s">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input" id="form-stacked-text" type="password" name="password_confirmation" placeholder="Confirm Password">
                                            </div>
                                        </div>
                                    </div>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Birth date:')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-width-1-1@s">
                                                <input id="timeDatePicker" class="uk-input" type="text" placeholder="{{__('Tap to select')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(function () {
                                            $('#timeDatePicker').datetimepicker({
                                                format: 'DD/MM/YYYY'
                                            });
                                        });
                                    </script>
                                    {{--Item--}}
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-5@m"> <label class="uk-form-label">{{__('Gender')}}</label></div>
                                        <div class="uk-width-4-5@m uk-grid-small" uk-grid>
                                            <div class="uk-width-1-1@s" style="padding-top: 10px">
                                                <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                                    <label><input class="uk-radio" type="radio" name="gender" value="1" checked> Male</label>
                                                    <label><input class="uk-radio" type="radio" name="gender" value="0"> Female</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Item--}}
                                    <div class="uk-grid-small">
                                        <button class="uk-button uk-button-primary uk-width-1-1">Register</button>
                                    </div>

                                </div>
                            </form>


                        @if(false)
                            <form class="uk-grid-small" role="form" method="POST" action="{{ route('register') }}" uk-grid>
                                {{ csrf_field() }}
                                <div class="uk-width-1-4@s">
                                    <input class="uk-input" type="text" placeholder="{{__('First name')}}">
                                </div>
                                <div class="uk-width-1-4@s">
                                    <input class="uk-input" type="text" placeholder="{{__('Father\'s name')}}">
                                </div>
                                <div class="uk-width-1-4@s">
                                    <input class="uk-input" type="text" placeholder="{{__('Grandpa name')}}">
                                </div>
                                <div class="uk-width-1-4@s">
                                    <input class="uk-input" type="text" placeholder="{{__('Surname')}}">
                                </div>
                                <div class="uk-width-1-1@s">
                                    <input class="uk-input" type="text" placeholder="{{__('Mather\'s name:')}}">
                                </div>
                                <div class="uk-width-1-1@s">
                                    <div class="uk-margin">
                                        <select class="uk-select">
                                            <option value="">Your nationality...</option>
                                            <option>Iraqi</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-width-1-1@s">
                                    <input class="uk-input" type="text" placeholder="{{__('Mather\'s name:')}}">
                                </div>

                                <div class="uk-width-1-1@s">
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                                            <input class="uk-input" id="form-stacked-text" name="email" type="text" placeholder="Email" value="{{!empty($email) ? $email : ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-1@s">
                                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                        <label><input class="uk-radio" type="radio" name="gender" value="1" checked> Male</label>
                                        <label><input class="uk-radio" type="radio" name="gender" value="0"> Female</label>
                                    </div>
                                </div>
                                <div class="uk-width-1-1@s">
                                    <input class="uk-input" type="text" placeholder="{{__('Mather\'s name:')}}">
                                </div>
                            </form>
                        <form class="uk-form-stacked" role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}


                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                                    <input class="uk-input" id="form-stacked-text" name="email" type="text" placeholder="Email" value="{{!empty($email) ? $email : ''}}">
                                </div>
                            </div>
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label><input class="uk-radio" type="radio" name="gender" value="1" checked> Male</label>
                                <label><input class="uk-radio" type="radio" name="gender" value="0"> Female</label>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                    <input class="uk-input" id="form-stacked-text" type="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                    <input class="uk-input" id="form-stacked-text" type="password" name="password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <button class="uk-button uk-button-primary uk-width-1-1">Register</button>
                                </div>
                            </div>
                        </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@if(false)
<section id="login" class="section">
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 col-sm-12 card border-light">
            @if(getSite()->registration == 0)
            <div class="login-form section-md text-center">
                <h1 class=" mytext-light"><i class="fa fa-ban" aria-hidden="true"></i>
                </h1>
                <h3>{{trans('main._reg_not_allowed')}}</h3>
                <p>{{trans('main._for_more_info')}} <a href="{{route('contact')}}">{{trans('main._here')}}</a></p>
            </div>
            @else
            <div class="login-form section-md">
                <div class="title d-flex justify-content-center">
                <h3>{{trans('main._register')}}</h3>
                </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{trans('main._name')}}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{trans('main._email')}}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                       <select name="gender" id="gender" class="custom-select col-12 form-control-dropdown">
                        <option selected class="">-- {{trans('main._gender')}} --</option>
                        <option value="1">{{trans('main._male')}}</option>
                        <option value="0">{{trans('main._female')}}</option>
                        </select>

                        @if ($errors->has('gender'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>
                
                    
                
                    <div class="form-row">
                        <div class="form-group col-6{{ $errors->has('password') ? ' has-error' : '' }}">
                          <input id="password" type="password" class="form-control" name="password" placeholder="{{trans('main._password')}}"  required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('main._confirm')}} {{trans('main._password')}}" required>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-dark btn-lg col-lg ">
                            {{trans('main._submit')}}
                        </button>
                    </div>
                </form>  
            </div>
            @endif
        </div>
    </div>
</section>
@endif
@endsection
