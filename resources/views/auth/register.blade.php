@extends('themes.'.getFrontendThemeName().'.v2.layout')
@section('title', 'register')
@section('head')
    <!-- IMPORTANT!!! remember CSRF token -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://www.google.com/recaptcha/api.js?render={{getReCaptchaSiteKey()}}"></script>

@endsection
@section('content')
    <section>
        <div class="pt-25">
            <div class="uk-container">
                <div class="uk-flex uk-flex-center uk-padding-small" uk-grid>
                    <register-form>
                    </register-form>
                </div>
            </div>
        </div>
    </section>
    @include('partial.frontend._full_loading')
@endsection
