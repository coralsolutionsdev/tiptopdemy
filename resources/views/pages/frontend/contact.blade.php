@extends('themes.'.getFrontendThemeName().'.v2.layout')
@section('title', 'Contact')
@section('head')
<!-- IMPORTANT!!! remember CSRF token -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://www.google.com/recaptcha/api.js?render={{getReCaptchaSiteKey()}}"></script>

@endsection
@section('content')
<section>
    <div class="pt-25">
        <div class="uk-container">
            <div class="uk-flex uk-flex-center" uk-grid>
                <div class="uk-card uk-card-default uk-card-body uk-width-1-1">
                    <div class="uk-grid" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1">
                            <form-builder></form-builder>
                        </div>
                        <div class="uk-width-1-2@m uk-width-1-1">
                            <h3>{{__('main._contact_info')}}</h3>
                            <div class="uk-margin-small">
                                <span uk-icon="icon: phone"></span> <span class="uk-margin-small-left uk-margin-small-right">+9647732534388</span>
                            </div>
                            <div class="uk-margin-small">
                                <span uk-icon="icon: location"></span> <span class="uk-margin-small-left uk-margin-small-right">Iraq - Baghdad</span>
                            </div>
                            <hr>
                            <div class="uk-margin-small uk-text-center">
                                <a target="_blank" href="https://www.facebook.com/Tiptop-demy-%D8%AA%D8%A8%D8%AA%D9%88%D8%A8-103810867929225" class="uk-icon-button" uk-icon="facebook" style="color: #0470E5"></a>
                                <a target="_blank" href="https://www.youtube.com/channel/UC-jD-kqLu-L_S6TzWAqF0fg/featured" class="uk-icon-button uk-text-danger" uk-icon="youtube"></a>
{{--                                <a target="_blank" href="https://api.whatsapp.com/send?phone=009647732534388;text=Hi%20,%20I%20need%20some%20help." class="uk-icon-button uk-text-success" uk-icon="whatsapp"></a>--}}
                                <a target="_blank" href="https://wa.me/+9647732534388?text=Hi%20,%20I%20need%20some%20help." class="uk-icon-button uk-text-success" uk-icon="whatsapp"></a>
                                <a target="_blank" href="mailto:info@tiptopdemy.com?subject=An inquiry about Tiptopdemy services" class="uk-icon-button uk-text-danger" uk-icon="mail"></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--@include('partial.frontend._full_loading')--}}
@endsection
