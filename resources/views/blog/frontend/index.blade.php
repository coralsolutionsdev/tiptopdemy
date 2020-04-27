@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('content')
<section>
	@include('partial.frontend._page-header')
	<div class="uk-background-default pt-25">
		<div class="uk-container">
			<div class="" uk-grid>
				<div class="uk-width-1-4@m blog-sidebar">
					@widget('home.blog.side_bar_menu', ['search_key' => $search_key])
				</div>
				<div class="uk-width-3-4@m ">
					{{-- Posts cards --}}
					@if(!empty($search_key))
					<h4 class="uk-text-muted">Search results ({{$posts->count()}})</h4>
					@endif
					@forelse($posts as $post)
					<div class="uk-child-width-1-1@m uk-margin-small" uk-grid>
						@if(!empty($search_key))
							<div class="" uk-grid>
								<a href="{{route('blog.posts.show',$post->slug)}}">
								<div class="uk-width-2-5@m uk-flex uk-flex-middle">
									<img src="{{$post->getMainImage()}}">
								</div>
								</a>
								<div class="uk-width-expand@m">
									<h3><a href="{{route('blog.posts.show',$post->slug)}}">{{$post->title}}</a></h3>
									<ul class="uk-iconnav uk-text-muted">
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: user; ratio: 0.8"></span><span><a href="#"> {{ucfirst($post->user->name)}}</a> </span></li>
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: calendar; ratio: 0.8"></span><span><a href="#"> {{$post->created_at->toFormattedDateString()}}</a></span></li>
										@if(!empty($post->categories()))
											<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: folder; ratio: 0.8"></span>
												@foreach($post->categories as $category)
													<span><a href=""> {{ucfirst($category->name)}}</a></span>@if($post->categories->count() > 1) <span> | </span> @endif
												@endforeach
											</li>
										@endif
										<li><span uk-icon="icon: heart; ratio: 0.8"></span>  <span class="reaction-count">{{$post->getReactionCount('like')}}</span>  </li>
									</ul>
									<p>
										{!! subContent($post->content, 500) !!}
									</p>
									<a href="{{route('blog.posts.show',$post->slug)}}">
										<span class="uk-button uk-button-primary">{{__('main.Read more')}}</span>
									</a>
								</div>
							</div>
						@else
						<div>
							<div class="uk-card uk-card-clear">
								<a href="{{route('blog.posts.show',$post->slug)}}">
								<div class="uk-inline-clip uk-transition-toggle" tabindex="0" style="width: 100%;max-height: 400px; overflow: hidden; object-fit: contain;">
									<img class="uk-transition-scale-up uk-transition-opaque" src="{{$post->getMainImage()}}" alt="" style="width: 100%">
								</div>
								</a>
								<div class="uk-card-body uk-padding-small" style="padding-left: 0px; padding-right: 0px">
									<h3><a href="{{route('blog.posts.show',$post->slug)}}">{{$post->title}}</a></h3>
									<ul class="uk-iconnav uk-text-muted">
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: user; ratio: 0.8"></span><span><a href="#"> {{ucfirst($post->user->name)}}</a> </span></li>
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: calendar; ratio: 0.8"></span><span><a href="#"> {{$post->created_at->toFormattedDateString()}}</a></span></li>
										@if(!empty($post->categories()))
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: folder; ratio: 0.8"></span>
											@foreach($post->categories as $category)
											<span><a href=""> {{ucfirst($category->name)}}</a></span>@if($post->categories->count() > 1) <span> | </span> @endif
											@endforeach
										</li>
										@endif
										<li><span class="{{$post->getReactionCount('like') > 0 ? 'uk-text-danger fas' : 'far' }} fa-heart reaction-icon"></span>  <span class="reaction-count">{{$post->getReactionCount('like')}}</span></li>
									</ul>
									<p>
										{!! subContent($post->content, 500) !!}
									</p>
									<div>
										<a href="{{route('blog.posts.show',$post->slug)}}">
											<span class="uk-button uk-button-primary">{{__('main.Read more')}}</span>
										</a>
									</div>
								</div>

							</div>
						</div>
						@endif
					</div>
                    @empty
                        <div class="uk-child-width-1-1@m" uk-grid>
                            <div>
                                <div class="uk-card uk-card-clear">
                                    <div class="uk-card-body uk-padding uk-text-center uk-placeholder">
										<span class="uk-text-muted" uk-icon="icon: ban; ratio: 3"></span>
										<h5 class="uk-margin-small">No records found</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
					@endforelse
				</div>
			</div>
		</div>
	</div>
</section>
@endsection