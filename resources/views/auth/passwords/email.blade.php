@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'Login')
@section('content')
    <section>
        <div class="pt-25" style="background-color: #F3F5F9">
            <div class="uk-container uk-height-large">
                <div class="uk-flex uk-flex-center " uk-grid>
                    <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m uk-padding">
                        <div class="uk-grid-divider uk-child-width-expand@s" uk-grid>
                            <div>
                                <div class="uk-text-center">
                                    @if(!empty(getSite()->logo))
                                        <img src="{{asset_image(getSite()->logo)}}" style="height: 60px" alt="">
                                    @endif
                                    <p class="uk-text-capitalize" style="font-size: 24px">{{__('auth.Reset Password')}}</p>
                                </div>

                                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                                    {{ csrf_field() }}

                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <div class="uk-margin-small">
                                                <label class="uk-form-label" for="">{{__('auth.E-Mail Address')}}:</label>
                                            </div>
                                            <input class="uk-input" name="email" type="text" placeholder="{{__('Email')}}" value="{{ old('email') }}" required>
                                            @if ($errors->has('email'))
                                                    <strong class="uk-text-danger">{{ $errors->first('email') }}</strong>
                                            @endif
                                        </div>
                                        <div class="uk-margin">
                                            <div class="uk-inline uk-width-1-1">
                                                <button class="uk-button uk-button-primary uk-width-1-1">{{__('auth.Send Password Reset Link')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@if(false)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
