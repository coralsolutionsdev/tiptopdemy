@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', Auth::user()->name)
@section('content')
<section id="profile">
    <div class="uk-container">
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                @if($status == \App\User::STATUS_PENDING)
                    <img src="{{asset_image('/assets/reading_01.png')}}" width="200">
                    <h4 class="uk-card-title uk-text-primary uk-text-normal">{{__('One more step!')}}</h4>
                    <p>Dear <strong>{{Auth::user()->first_name}}</strong> {{__('Welcome to ')}} {{getApplicationDomain()}}</p>
                    <p>One more step, to complete your registration please verify your account. <br>
                        An email has been sent to your email "<strong class="color-primary">{{Auth::user()->email}}</strong>" with the activation instruction.
                    </p>
                    <p>If you haven't received your activation mail! please click on the link below.</p>
                    <a class="uk-button uk-button-primary" href="">Resend verification email</a>
                @else
                    <img src="{{asset_image('/assets/reading_01.png')}}" width="200">
                    <h4 class="uk-card-title uk-text-danger uk-text-normal">{{__('Oops, something wrong!')}}</h4>
                    <p>Dear <strong>{{Auth::user()->first_name}}</strong></p>
                    <p>
                        Your account has been disable for a reason, to clarify about this issue lease contact the support team. <br>
                    </p>
                    <h4 class="uk-text-primary">support@tiptopdemy.com</h4>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

