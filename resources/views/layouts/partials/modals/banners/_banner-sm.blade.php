<section id="banner">
	<div class="container section-sm">
		<div class="row">
			@foreach($banner_sms as $banner)
				<div class="col-lg-4 padding-0">
					<div class="photo d-flex align-items-center justify-content-center">
						<div class="photo-image">
							@if($banner->image != null)
							<img src="{{asset('/uploads/banner/images/'.$banner->image)}}" class="img-fluid" alt="">
							@else
							<img src="{{asset('/uploads/temp/empty.png')}}" class="img-fluid" alt="">
							@endif
						</div>
						<div class="photo-caption d-flex justify-content-center">
							<div class="caption col-10 {{($banner->font_color ==  'light') ? 'text-white' : ''}} text-justify">
								{!!$banner->body!!}
								@if($banner->link != null)
								<div class="text-center">
								<a href="" class="btn {{($banner->font_color ==  'light') ? 'btn-outline-light btn-dark' : 'btn-primary'}}">{{trans('main._read_more')}}</a>
								</div>
								@endif
							</div>
						</div>						
					</div>
				</div>
			@endforeach	
		</div>
	</div>
</section>