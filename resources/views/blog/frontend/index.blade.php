@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('content')
<section>
	@include('partial.frontend._page-header')
	<div class="uk-background-default pt-25">
		<div class="uk-container">
			<div class="" uk-grid>
				<div class="uk-width-2-3@m ">
					{{-- Posts cards --}}
					@forelse($posts as $post)
					<div class="uk-child-width-1-1@m" uk-grid>
						<div>
							<div class="uk-card uk-card-clear">
								<div class="uk-inline-clip uk-transition-toggle" tabindex="0" style="width: 100%;max-height: 400px; overflow: hidden; object-fit: contain;">
									<img class="uk-transition-scale-up uk-transition-opaque" src="{{asset_image($post->image)}}" alt="" style="width: 100%">
								</div>
								<div class="uk-card-body" style="padding-left: 0px; padding-right: 0px">
									<h3><a href="{{route('blog.post.show',$post->slug)}}">{{$post->title}}</a></h3>
									<ul class="uk-iconnav uk-text-muted">
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: user; ratio: 0.8"></span><span><a href="#"> {{ucfirst($post->user->name)}}</a> </span></li>
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: calendar; ratio: 0.8"></span><span><a href="#"> {{$post->created_at->toFormattedDateString()}}</a></span></li>
										<li class="uk-flex uk-flex-middle"><span  uk-icon="icon: folder; ratio: 0.8"></span><span><a href="{{route('blog.category.show',$post->category->id)}}"> {{ucfirst($post->category->title)}}</a></span></li>
									</ul>
									<p>
										{!! $post->content !!}
									</p>
									<div>
										<a href="{{route('blog.post.show',$post->slug)}}">
											<span class="uk-button uk-button-primary">{{__('Read more')}}</span>
										</a>
									</div>
								</div>

							</div>
						</div>
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
				<div class="uk-width-1-3@m blog-sidebar">
					@widget('home.blog.side_bar_menu')
				</div>
			</div>
		</div>
	</div>
</section>
@endsection