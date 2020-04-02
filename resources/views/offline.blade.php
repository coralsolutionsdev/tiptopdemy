@extends('themes.'.getFrontendThemeName().'.layout')
@section('title','Offline')
@section('content')
	<section>
		<div class="uk-container">
			<div class="uk-flex uk-flex-center uk-padding" uk-grid>
				<div class="uk-card uk-card-default uk-card-body uk-width-2-3@m uk-padding">
					<div class="uk-child-width-expand@s" uk-grid>
						<div>
							<div class="uk-text-center">
								<img src="{{asset_image('/assets/interaction_design.png')}}" width="300">
							</div>
						</div>
						<div>
							<div class="uk-flex-center uk-text-center" style="padding-top: 50px">
								<div>
									<h3 class="uk-card-title uk-text-primary">We will come back soon</h3>
									<p>
										{{getApplicationDomain()}} website is currently offline due the maintenance and development process.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

