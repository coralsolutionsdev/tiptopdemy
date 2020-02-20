<section id="banner">
	<div class="container section-md">
			@foreach($banner_mds as $banner)
			<div class="row padding-0 bg-white">
				@if($banner->position == 'left')
				<div class="col-lg-6 col-md-12 padding-0 banner_fadeput">
					@if($banner->image != null)
					<img src="{{asset('/uploads/banner/images/'.$banner->image)}}" class="card-img rounded-0" alt="">
					@else
					<img src="{{asset('/uploads/temp/empty.png')}}" class="card-img" alt="">
					@endif
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="text-justify card-body">	
						<p class="">{!!$banner->body!!}</p>
						@if($banner->link != null)
						<div class="text-center"><a href="" class="btn {{($banner->font_color ==  'light') ? 'btn-outline-light btn-dark' : 'btn-primary'}}">{{trans('main._read_more')}}</a></div>
						@endif
					</div>
				</div>
				@else
				<div class="col-lg-6 col-md-12">
					<div class="text-justify card-body">	
						<p class="">{!!$banner->body!!}</p>
						@if($banner->link != null)
						<div class="text-center"><a href="" class="btn {{($banner->font_color ==  'light') ? 'btn-outline-light btn-dark' : 'btn-primary'}}">{{trans('main._read_more')}}</a></div>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-12 padding-0 banner_fadeput">
					@if($banner->image != null)
					<img src="{{asset('/uploads/banner/images/'.$banner->image)}}" class="card-img rounded-0" alt="">
					@else
					<img src="{{asset('/uploads/temp/empty.png')}}" class="card-img" alt="">
					@endif
				</div>
				
				@endif
			</div>

			@endforeach	
	</div>
</section>


