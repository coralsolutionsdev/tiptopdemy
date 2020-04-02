@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'Login')
@section('content')
    <section>
        <div class="pt-25" style="background-color: #F3F5F9">
            <div class="uk-container">
                <div class="uk-flex uk-flex-center" uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-3-4@m uk-padding">
                        <div class="uk-grid-divider uk-child-width-expand@s" uk-grid>
                            <div>
                                <div class="uk-text-center">
                                    @if(!empty(getSite()->logo))
                                        <img src="{{asset_image(getSite()->logo)}}" style="height: 60px" alt="">
                                    @endif
                                    <p style="font-size: 24px">{{__('Sign in')}}</p>
                                </div>

                                <form class="uk-form-stacked" role="form" method="POST" action="{{ route('login.custom') }}">
                                    {{ csrf_field() }}

                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                                            <input class="uk-input" id="form-stacked-text" name="email" type="text" placeholder="Email">

                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                            <input class="uk-input" id="form-stacked-text" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <button class="uk-button uk-button-primary uk-width-1-1">log in</button>
                                        </div>
                                    </div>
                                </form>
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
                            </div>
                            <div>
                                <div class="uk-flex-center uk-text-center" style="padding-top: 20px">
                                    <div>
                                        <img src="{{asset_image('/assets/tutorial.png')}}" width="150">
                                        <p class="uk-text-bold" style="font-size: 18px">{{getSite()->name}}</p>
                                        <p style="margin: 0px; padding: 0px; text-align: justify; text-justify: inter-word">
                                            {{getSite()->description}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
