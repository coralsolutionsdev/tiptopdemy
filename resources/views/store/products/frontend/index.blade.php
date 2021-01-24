@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
	<style>
		.color-option{
			height: 22px;
			width: 22px !important;
			border-radius: 50%;
			border: 1px solid #566573;
			display: inline-block;
		}
	</style>
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
	<section>
		<div class="store uk-container uk-margin-medium-bottom" style="background-color: transparent">
			{{--header--}}
			@include('partial.frontend._page-header')
			{{--body--}}
			<div class="uk-grid-small uk-child-width-1-1" uk-grid>
				<div class="uk-visible@m">
					@widget('home.product.top_bar_menu')
				</div>
				<div>
					<div class="uk-grid-small" uk-grid>
						<div class="uk-width-1-4 uk-visible@m">
							<div class="uk-card uk-card-default uk-card-body" style="padding: 10px">
								@widget('home.product.side_bar_menu')
							</div>
						</div>
						<div class="uk-width-expand">
							@if(!empty($products) && $products->count() > 0)
								<div class="uk-grid-small uk-child-width-1-3@m" uk-grid="masonry: true">
									@foreach($products as $product)
										<div>
											<div id="{{$product->id}}" class="product uk-card uk-card-default uk-card-body uk-padding-remove uk-box-shadow-hover-large" style="overflow: hidden">
												<a href="{{route('store.product.show', $product->slug)}}">
													<div style="max-height: 200px; overflow: hidden">
														<div class="uk-text-center">
															<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
																<img class="product-primary-image" data-src="{{$product->getProductPrimaryImage()}}" sizes="(min-width: 500px) 500px, 100vw" width="500" alt="" uk-img>
																<img class="uk-transition-scale-up uk-position-cover" src="{{$product->getProductAlternativeImage()}}" alt="">
															</div>
														</div>
													</div>
												</a>
												<div class="" style="padding:20px 15px">
													<a href="{{route('store.product.show', $product->slug)}}">
														<div class="uk-grid-collapse uk-text-center" style="position: absolute; width: 90%; margin-top: -50px;" uk-grid>
															<div class="uk-width-expand">
																<input type="hidden" class="product-id-input" value="{{$product->id}}">
																<input type="hidden" class="product-name-input" value="{{$product->name}}">
																<input type="hidden" class="product-price-input" value="{{$product->price}}">
																<input type="hidden" class="product-primary-image-input" value="{{$product->getProductPrimaryImage()}}">
																<input type="hidden" class="product-sku-input" value="{{$product->sku}}">
															</div>
															<div class="uk-width-auto">
																<div class="uk-card uk-card-body bg-white" style="padding:3px 10px; color: black; font-weight: 700; font-size: 24px; border-radius: 10px 10px 0 0">
																	<span class="uk-text-primary">$</span> <span class="product-price">{{$product->price}}</span>
																</div>
															</div>
														</div>
														<div style="font-weight: 700; color: black" class="product-name">{{$product->name}}</div>
														<div style="" class="product-sku">{{$product->sku}}</div>
														<div style="height: 50px">
															{!! subContent($product->description, 130) !!}
														</div>
														<div style="margin-bottom: 10px">
															<span><img class="uk-border-circle" src="{{$product->user->getProfilePicURL()}}" style="width: 20px; height: 20px; object-fit: cover"></span> <span>{{__('main.By')}}: </span> <span> {{$product->user->name}}</span>
														</div>
													</a>
													<div style="">
														@if($product->hasPurchased())
															<a class="uk-button uk-button-primary uk-width-1-1" href="{{route('store.product.show', $product->slug)}}"><span uk-icon="icon:  play-circle"></span> {{__('main.View lesson')}}</a>
														@else
															<button class="uk-button uk-button-primary uk-width-1-1 cart-action {{$product->isInCart() ? 'in-cart' : ''}} ">{!!  $product->isInCart() ? '<span uk-icon="icon: check"></span>'.__('main.Added to cart') : '<span uk-icon="icon: cart"></span>'.__('main.Add to cart') !!} </button>
														@endif
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							@else
								<div class="uk-grid-small uk-child-width-1-1@m uk-text-center" uk-grid>
									<div>
										<div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large">
											{{__('main.There is no form items yet.')}}
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('partial.scripts._cart')
	</section>
@endsection