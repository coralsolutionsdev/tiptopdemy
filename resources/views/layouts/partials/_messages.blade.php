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
	<div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
		{{ session()->get('success') }}
	</div>
@endif

@if(session()->has('warning'))
  <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    {{ session()->get('warning') }}
  </div>
@endif

@if(session()->has('danger'))
  <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    {{ session()->get('danger') }}
  </div>
@endif
