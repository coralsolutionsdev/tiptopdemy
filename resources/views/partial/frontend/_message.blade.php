@if(count($errors))
    <div class="uk-alert-danger uk-margin-medium-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
       <ul>
           @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
    </div>
@endif

@if(session()->has('success'))
    <div class="uk-alert-success uk-margin-medium-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

@if(session()->has('warning'))
    <div class="uk-alert-warning uk-margin-medium-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('warning') }}</p>
    </div>
@endif

@if(session()->has('danger'))
    <div class="uk-alert-danger uk-margin-medium-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('danger') }}</p>
    </div>
@endif
