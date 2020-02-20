<section id="banner">
	<div class="{{($banner->image != null) ? 'parallax-banner': ''}} d-flex align-items-center" data-parallax="scroll" data-z-index="-1" data-image-src="{{asset('/uploads/banner/images/'.$banner->image)}}">
	    <div class="container section d-flex justify-content-center">
	    	<div class="banner-body {{($banner->position == 'right') ? 'col-md-10 col-lg-6 ml-auto' : ''}} {{($banner->position == 'left') ? 'col-md-10 col-lg-6 mr-auto' : ''}} {{($banner->position == 'center') ? 'col-10' : ''}}">
	    		<div class="{{($banner->font_color ==  'light') ? 'text-white' : ''}} text-justify fade-in">
                {!!$banner->body!!}
	    		</div>
	    		@if($banner->link != null)
	    		<div class="text-center">
	    			<a href="{{$banner->link}}" class="btn {{($banner->font_color ==  'light') ? 'btn-outline-light btn-dark' : 'btn-primary'}}"> {{trans('main._read_more')}}</a>
	    		</div>
	    		@endif
	    	</div>
	    </div>
	</div>
</section>
