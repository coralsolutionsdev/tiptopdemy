@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<section>
		<div class="store uk-container uk-margin-medium-bottom" style="background-color: transparent">
			{{--header--}}
			@include('partial.frontend._page-header')
			{{--body--}}
			<div class="uk-grid-small uk-child-width-1-1" uk-grid>
				<div>
					<div class="uk-grid-small" uk-grid>
						<div class="uk-width-1-4 uk-visible@m">
							<div class="uk-card uk-card-default uk-card-body" style="padding: 10px">
								@widget('home.blog.side_bar_menu', ['search_key' => $search_key])
							</div>
						</div>
						<div class="uk-width-expand">
								<div class="uk-grid-small uk-child-width-1-1@m" uk-grid="masonry: true">
									@forelse($posts as $post)
										<div>
											<div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small">
												<a href="{{route('blog.posts.show',$post->slug)}}">
													<div class="uk-inline-clip uk-transition-toggle" tabindex="0" style="width: 100%;max-height: 400px; overflow: hidden; object-fit: contain;">
														<img class="uk-transition-scale-up uk-transition-opaque" src="{{$post->getMainImage()}}" alt="" style="width: 100%">
													</div>
												</a>
												<div class="uk-card-body uk-padding-small post-content" style="padding-left: 0px; padding-right: 0px">
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
														{!! readMore($post->content) !!}
													</p>
													<div>
														<a href="{{route('blog.posts.show',$post->slug)}}">
															<span class="uk-button uk-button-primary">{{__('main.Read more')}}</span>
														</a>
													</div>
												</div>

											</div>
										</div>
									@empty
										<div>
											<div class="uk-grid-small uk-child-width-1-1@m uk-text-center" uk-grid>
												<div>
													<div class="uk-card uk-card-default uk-padding uk-card-body uk-box-shadow-hover-small">
														<div class="uk-alert-warning" uk-alert>
															<p>{{__('main.There is no form items yet.')}}</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									@endforelse
								</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		@include('partial.scripts._cart')
</section>
<script>
	$(function() {
		var ifr = $("iframe");
		ifr.attr("scrolling", "no");
		ifr.attr("src", ifr.attr("src"));
		var newItemWidth = parseInt($('.post-content').width());
		console.log(newItemWidth);
		var itemHeight = ifr.attr("height");
		var itemWidth = ifr.attr("width");
		var r = (itemWidth / newItemWidth) * 100;
		var newItemHeight = (itemHeight * 100) / r;
		ifr.attr("width",newItemWidth);
		ifr.attr("height",newItemHeight);
	});
</script>
@endsection