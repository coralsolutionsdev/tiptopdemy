@if(count($errors))
    <div class="uk-alert-danger uk-margin-small-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
       <ul>
           @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
    </div>
@endif

@if(session()->has('success'))
{{--    <div class="uk-alert-success uk-margin-small-top" uk-alert>--}}
{{--        <a class="uk-alert-close" uk-close></a>--}}
{{--        <p>{{ session()->get('success') }}</p>--}}
{{--    </div>--}}
    <script>
        UIkit.notification("<span uk-icon='icon: check'></span> "+"{{ session()->get('success')}}", {pos: 'top-center', status:'success'})
    </script>
@endif

@if(session()->has('warning'))
    <div class="uk-alert-warning uk-margin-small-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('warning') }}</p>
    </div>
@endif

@if(session()->has('danger'))
    <div class="uk-alert-danger uk-margin-small-top" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('danger') }}</p>
    </div>
@endif
