@if(count($errors))
    <div class="alert alert-danger">
        <ul>
            <strong>Warning:</strong>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('success'))
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

@if(session()->has('warning'))
    <div class="uk-alert-warning" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('warning') }}</p>
    </div>
@endif

@if(session()->has('danger'))
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('danger') }}</p>
    </div>
@endif
