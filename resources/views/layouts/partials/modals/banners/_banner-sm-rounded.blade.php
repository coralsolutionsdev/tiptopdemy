@if($banner_sms_rounded_count > 0)
<section id="banner">
	<div class="container section-sm">
		<div class="row d-flex justify-content-center text-uppercase section-sm">
			<h2>Our Staff</h2>
		</div>
		<div class="row d-flex justify-content-center">
			@foreach($banner_sms_rounded as $banner)
				<div class="col-lg-3">

					<div class="card border-light banner-rounder">
						<div class="photo d-flex justify-content-center">	
							@if($banner->image != null)
							<img src="{{asset('/uploads/banner/images/'.$banner->image)}}" class="card-img-top" alt="">
							@else
							<img src="{{asset('/uploads/temp/empty.png')}}" class="card-img-top" alt="">
							@endif
						</div>
						<div class="text-center">
						  <p class="">{!!$banner->body!!}</p>
						</div>
					</div>

				</div>

			@endforeach	

		</div>
	</div>
</section>
@endif