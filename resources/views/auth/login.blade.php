@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'Login')
@section('head')
    <!-- IMPORTANT!!! remember CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        function callbackThen(response){
            // read HTTP status
            // console.log(response.status);

            // read Promise object
            response.json().then(function(data){
                // console.log(data);
            });
        }
        function callbackCatch(error){
            console.error('Error:', error)
        }
        function myCustomValidation(token) {
            $('.recaptcha-validation-required').attr('disabled', false)
            $("[name='g-recaptcha-response']").val(token);
        }
    </script>

    {!! htmlScriptTagJsApi([
           'action' => 'homepage',
           'callback_then' => 'callbackThen',
           'callback_catch' => 'callbackCatch',
           'custom_validation' => 'myCustomValidation'
       ]) !!}

@endsection
@section('content')
    <section>
        <div class="pt-25" style="">
            <div class="uk-container">
                <div class="uk-flex uk-flex-center" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-1-4@m uk-padding">
                        <div class="uk-grid-divider uk-child-width-expand@s" uk-grid>
                            <div>
                                <div class="uk-text-center">
                                    @if(!empty(getSite()->logo))
                                        <img src="{{asset_image(getSite()->logo)}}" style="height: 60px" alt="">
                                    @endif
                                    <p class="uk-text-capitalize" style="font-size: 24px">{{__('sign in')}}</p>
                                </div>

                                <form class="uk-form-stacked" role="form" method="POST" action="{{ route('login.custom') }}">
                                    {{ csrf_field() }}

                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                                            <input class="uk-input {{count($errors) ? 'uk-form-danger' : ''}}" id="form-stacked-text" name="email" type="text" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                            <input class="uk-input {{count($errors) ? 'uk-form-danger' : ''}}" id="form-stacked-text" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <a href="{{ url('/password/reset') }}" class="font-family-Roboto" style="font-size: 14px;">{{trans('auth.Forgot Password?')}}</a>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <button class="uk-button uk-button-primary uk-width-1-1 recaptcha-validation-required">{{__('log in')}}</button>
                                        </div>
                                    </div>
                                </form>
                                @if(false)
                                <div class="uk-text-center" style="padding-bottom: 15px">
                                    Or, Login with..
                                </div>
                                <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
                                    <div class="disabled-div">
                                        <button class="uk-button uk-button-primary uk-width-1-1" style="background-color: #3B5998"><span class="uk-margin-small-right" uk-icon="facebook"></span> Facebook</button>
                                    </div>
                                    <div class="disabled-div">
                                        <a href="{{route('login.socialite','google')}}" class="uk-button uk-button-primary uk-width-1-1" style="background-color: #D34836"><span class="uk-margin-small-right" uk-icon="google"></span> Google</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
