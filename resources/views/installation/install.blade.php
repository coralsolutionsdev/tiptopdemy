@extends('layouts.app')
@section('title','Instalation')
@section('content')
<nav class="my-nav navbar navbar-expand-lg navbar-light sticky-top">
  	<div class="container">
  		<h5 class="text-muted">Welcome to Coral installation wizard ...</h5>
  	</div>
</nav>
<section>
	<div class="container section d-flex justify-content-center">
		<!--Install page-->
		<div class="section-md">
            @Include('layouts.partials._messages')
        </div>
		<div id="install" class="col-8 card border-light">
			<div class="row">	
				<div class="col-4 text-center section">
					<br>
					<div class=""><h3>CORAL</h3></div>
					<div class=" text-muted"><h5>Instalation wizard</h5></div>
					<div class="section-sm"><img src="{{asset('/uploads/temp/logo.png')}}" height="150" ></div>
					<div class="text-muted">v 1.0 Beta</div>
				</div>
				<div class="col-8 section-md">
					<form method="POST" action="{{ route('site.store') }}">
                	{{csrf_field()}}
					<!--installation-->
					<div class="install-tabs d-flex justify-content-center">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
							<a class="nav-link active" id="step-one-tab" data-toggle="pill" href="#pills-one" role="tab" aria-controls="pills-one" aria-expanded="true">1</a>
							</li>
							<li class="nav-item">
							<a class="nav-link" id="step-two-tab" data-toggle="pill" href="#pills-two" role="tab" aria-controls="pills-two" aria-expanded="true">2</a>
							</li>
							<li class="nav-item last">
							<a class="nav-link" id="step-three-tab" data-toggle="pill" href="#pills-three" role="tab" aria-controls="pills-three" aria-expanded="true">3</a>
							</li>
						</ul>
					</div>
					<div class="tab-content section-sm" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="step-one-tab">
							<!--Page one-->
							<div class="col">
								<div class="section-sm">
									<h4>Site Information</h4>
								</div>
								<div class="form-group">
                                <input type="text" name="site_name" class="form-control" value="" placeholder="Site Title" required>
	                            </div>
	                            <div class="form-group">
	                                <textarea name="desicription" class="form-control" placeholder="Site desicription ...."></textarea>
	                            </div>
	                            <div class="form-group col-7 padding-0">
	                                <select name="lang" class="form-control" required>
	                                <option disabled selected value> -- select the site langauge -- </option>
	                                <option value="en")><span>EN (English)</span></option>
	                                <option value="ar")><span>AR (العربية)</span></option>
	                                </select>   
	                            </div>
	                            <div class="form-group col-7 padding-0">
	                                <select name="theme" class="form-control" required>
	                                <option disabled selected value> -- select the site theme -- </option>
	                                <option value="coral-light")><span>Coral-light (Default)</span></option>
	                                </select>   
	                            </div>
	                            
	                            <!--form item-->
				                <div class="form-group d-flex align-items-center">
				                    <div class="col-md-4 padding-0">
				                        <label>Site Activation:</label>
				                    </div>
				                    <div class="col-md-8">
				                        <input type="checkbox" name="active" class="toogle-switch" value="1" checked>
				                    </div>
				                </div>
				                <!--form item-->
				                <div class="form-group d-flex align-items-center">
				                    <div class="col-md-4 padding-0">
				                        <label>Registration:</label>
				                    </div>
				                    <div class="col-md-8">
				                        <input type="checkbox" name="registration" class="toogle-switch" value="1" checked>
				                    </div>
				                </div>
	                         
							</div>
						</div>
						<div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="step-two-tab">
							<!--Page one-->
							<div class="col">
								<div class="section-sm">
									<h4>Site Information</h4>
								</div>
								<div class="form-group">
	                                <input type="text" name="admin_name" class="form-control" value="" placeholder="Admin name" required>
	                            </div>
								<div class="form-group">
	                                <input type="text" name="email" class="form-control" value="" placeholder="Admin email" required>
	                            </div>
	                            <div class="form-group">
	                                <input type="password" class="form-control" name="password" placeholder="Password" required>
	                            </div>
	                            
	                            <div class="form-group">
	                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
	                            </div>
									</div>
						</div>
						<div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="step-three-tab">
							<!--Page three-->
							<div class="col">
								<div class="section-sm">
									<h4>Confirm Installation</h4>
								</div>
								<div>
									<h5>Are you sure about the submitted information?</h5>
									<p><span class="text-primary">Note:</span> For security reason, delete the installation folder after finishing wizard.</p>
									<br>
									<div class="text-center">
										<button type="submit" class="btn btn-primary col-4">Install Now</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--installation-->
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection