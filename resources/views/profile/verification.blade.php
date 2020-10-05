@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', Auth::user()->name)
@section('content')
    <div class="profile uk-container uk-margin-medium-bottom" style="background-color: transparent">
        {{--header--}}
        @include('partial.frontend._page-header')
        {{--body--}}
        <div class="uk-grid-small uk-padding-remove" uk-grid>
            <div class="uk-width-1-1">
                <div class="uk-card uk-card-default uk-card-body uk-text-center">
                    @if($status == \App\User::STATUS_PENDING)
                        <img src="{{asset_image('/assets/reading_01.png')}}" width="200">
                        <h3 class="uk-card-title uk-text-primary uk-text-normal">{{__('main.One more step to activate your account')}}</h3>
                        <p>{{__('main.Dear', ['name' => Auth::user()->first_name])}}, {{__('main.Thank you to join us')}}</p>
                        <p>{{__('main.To complete your registration please verify your account')}}<br>
                            {{__('main.An email has been sent to your email')}} "<strong class="color-primary">{{Auth::user()->email}}</strong>" {{__('main.with the activation instruction')}}.
                        </p>
                        <p>{{__('main.If you haven\'t received your activation mail! please click on the link below')}}.</p>
                        <a class="uk-button uk-button-primary" href="{{route('account.resend.activation')}}">{{__('main.Resend verification email')}}</a>
                    @else
                        <img src="{{asset_image('/assets/reading_01.png')}}" width="200">
                        <h4 class="uk-card-title uk-text-danger uk-text-normal">{{__('Oops, something wrong!')}}</h4>
                        <p>{{__('main.Dear', ['name' => Auth::user()->first_name])}}</p>
                        <p>
                            {{__('main.Your account has been disable for a reason, to clarify about this issue lease contact the support team')}}. <br>
                        </p>
                        <h4 class="uk-text-primary">support@tiptopdemy.com</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

