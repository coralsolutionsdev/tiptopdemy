@if($posts_count > 0)
<div id="blog-posts" class="container">
	<div class="row section d-flex justify-content-center">
			<h2 class="text-uppercase">{{trans('main._last_posts')}}</h2>
	</div>
	<div class="row">
		@foreach($posts as $post)
		<div class="col-md-12 col-lg-4 post">
			<div class="card border-light">
				<a href="{{route('post.show', $post->id)}}">
				<div class="photo d-flex justify-content-center align-items-center">
					<div class="photo-image d-flex align-items-center">
                        <img src="{{asset('/uploads/blog/images/'.$post->image)}}" class="img-fluid" alt="">
                    </div>
                    
                    <div class="photo-caption album d-flex justify-content-center align-items-center"> 
                        <div class="caption">
                            <div class="album-title caption-icon">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
				</div>
				</a>
				<div class="body">
					<a href="{{route('post.show', $post->id)}}"><h5 class="card-title">{{ucfirst($post->title)}}</h5></a>
					<p class="card-text text-justify">{{substr(strip_tags($post->body),0,150)}} {{strlen($post->body) > 150 ? "...": "" }}</p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<div class="row d-flex justify-content-center section-md">
		<a href="{{ URL::asset('/blog') }}" class="btn btn-primary">{{trans('main._read_more')}}</a>
	</div>
</div>
@endif