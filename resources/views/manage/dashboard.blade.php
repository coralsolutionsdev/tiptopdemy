@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Admin Dashboard')
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 Dashboard</p>
@endsection
@section('content')
<section>
	<div class="row">
		<div class="col-lg-3">
			<div class="statistic-widget card border-light">
				<div class="card-body">
					<div><i class="far fa-user fa-2x text-primary"></i></div>
					<div class="text-secondary">Tickets Answered</div>
					<div class="h2">201</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="statistic-widget card border-light">
				<div class="card-body">
					<div><i class="far fa-user fa-2x text-success"></i></div>
					<div class="text-secondary">Tickets Answered</div>
					<div class="h2">201</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="statistic-widget card border-light">
				<div class="card-body">
					<div><i class="far fa-user fa-2x text-warning"></i></div>
					<div class="text-secondary">Tickets Answered</div>
					<div class="h2">201</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="statistic-widget card border-light">
				<div class="card-body">
					<div><i class="far fa-user fa-2x text-danger"></i></div>
					<div class="text-secondary">Tickets Answered</div>
					<div class="h2">201</div>
				</div>
			</div>
		</div>

	</div>
</section>
@endsection
