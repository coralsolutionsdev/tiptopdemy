@if(count($errors))
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            <strong>Warning:</strong>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('success'))
{{--	<div class="alert alert-success">--}}
{{--      <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--        <span aria-hidden="true">&times;</span>--}}
{{--      </button>--}}
{{--		--}}
{{--	</div>--}}
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

@if(session()->has('warning'))
{{--  <div class="alert alert-warning">--}}
{{--      <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--        <span aria-hidden="true">&times;</span>--}}
{{--      </button>--}}
{{--    {{ session()->get('warning') }}--}}
{{--  </div>--}}
  <div class="uk-alert-warning" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p>{{ session()->get('warning') }}</p>
  </div>
@endif

@if(session()->has('danger'))
{{--  <div class="alert alert-danger">--}}
{{--      <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--        <span aria-hidden="true">&times;</span>--}}
{{--      </button>--}}
{{--    {{ session()->get('danger') }}--}}
{{--  </div>--}}
  <div class="uk-alert-danger" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p>
          {{ session()->get('danger') }}
      </p>
  </div>
@endif
