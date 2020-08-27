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
@endsection
@section('content')
	<div class="store uk-container uk-padding-remove" style="background-color: transparent">
	{{--header--}}
	@include('store.products.frontend._page_header')
	{{--body--}}
		<div class="uk-grid-small uk-child-width-1-1" uk-grid>
			<div>
				@widget('home.product.top_bar_menu')
			</div>
			<div>
				<div class="uk-grid-small" uk-grid>
					<div class="uk-width-1-4">
						<div class="uk-card uk-card-default uk-card-body" style="padding: 10px">
							@widget('home.product.side_bar_menu')
						</div>
					</div>
					<div class="uk-width-expand">
						@if(!empty($products) && $products->count() > 0)
						<div class="uk-grid-small uk-child-width-1-3@m" uk-grid>
							@foreach($products as $product)
							<div>
								<div class="product uk-card uk-card-default uk-card-body uk-padding-remove uk-box-shadow-hover-large" style="overflow: hidden">
									<a href="{{route('store.product.show', $product->slug)}}">
										<div style="height: 200px; overflow: hidden">
											<div class="uk-text-center">
												<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
													<img src="{{$product->getProductPrimaryImage()}}" alt="">
													<img class="uk-transition-scale-up uk-position-cover" src="{{$product->getProductAlternativeImage()}}" alt="">
												</div>
											</div>
										</div>
									</a>
									<div class="" style="padding:20px 15px">
										<a href="{{route('store.product.show', $product->slug)}}">
											<div class="uk-grid-collapse uk-text-center" style="position: absolute; width: 90%; margin-top: -45px;" uk-grid>
												<div class="uk-width-expand"></div>
												<div class="uk-width-auto">
													<div class="uk-card uk-card-default uk-card-body" style="padding:3px 10px; color: black; font-weight: 700; font-size: 18px">
														<span class="uk-text-primary">$</span> {{$product->price}}
													</div>
												</div>
											</div>
											<div style="font-weight: 700; color: black">{{$product->name}}</div>
											<div style="height: 50px">
												{!! subContent($product->description, 150) !!}
											</div>
											<div style="margin-bottom: 10px">
												<span><img class="uk-border-circle" src="{{$product->user->getProfilePicURL()}}" style="width: 20px; height: 20px; object-fit: cover"></span> <span>{{__('main.By')}}: </span> <span> {{$product->user->name}}</span>
											</div>
										</a>
										<div style="">
											<button class="uk-button uk-button-primary uk-width-1-1"><span uk-icon="icon: cart"></span> {{__('main.Add to cart')}}</button>
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
@if(false)
<section>
	@include('partial.frontend._page-header')
	<div class="uk-background-default pt-25">
		<div class="uk-container">
			<div class="" uk-grid>
				<div class="uk-width-1-4@m blog-sidebar">
					@widget('home.product.side_bar_menu')
				</div>
				<div class="uk-width-expand@m">
					<div class="uk-grid-small uk-child-width-1-1@s uk-child-width-1-3@m" uk-grid style="margin-bottom: 10px">
						<div class="uk-flex uk-flex-middle">
							<p>{{__('main.Showing products')}} {{$products->count()}} {{__('main.of')}} {{$products->count()}}</p>
						</div>
						<div></div>
						<div class="" >
							<form>
									<div class="">
										<select class="uk-select">
											<option>{{__('main.Default Sort')}}</option>
											<option>{{__('main.Sort by name')}}</option>
											<option>{{__('main.Sort by position')}}</option>
											<option>{{__('main.Price low to high')}}</option>
											<option>{{__('main.Price high to low')}}</option>
										</select>
									</div>
							</form>

						</div>

					</div>
					<div>
						<hr class="">
					</div>
					<div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid uk-height-match="target: > div > .uk-card">
						@foreach($products as $product)
								<div>
									<div class="uk-card uk-card-default uk-card-body uk-padding-small product-card">
										<div class="uk-grid-small uk-child-width-1-1@s uk-text-center" uk-grid>
											<a href="{{route('store.product.show', $product->slug)}}">

											</a>
											<div>
												<a href="{{route('store.product.show', $product->slug)}}">
												<div>
													<div style="font-size: 22px"></div>
													<div style="font-size: 18px" class="uk-text-primary">$ {{$product->price}}</div>
													<br>
												</div>
												</a>
												<div>
												</div>
											</div>
										</div>
										@if(false)
										<div class="uk-text-center">

												<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
													<img class="product-image" src="{{$product->getProductPrimaryImage()}}" alt="">
{{--													@if(!empty($product->getProductAlternativeImage()))--}}
{{--														<img class="uk-transition-scale-up uk-position-cover" src="{{$product->getProductAlternativeImage()}}" alt="" style="width: 100%; background-color: green; object-fit: cover;">--}}
{{--													@endif--}}
												</div>
											</a>
										</div>
										<div class="product-info">
											<div><span class="uk-text-primary name">{{$product->name}}</span></div>
											<div class="" style="margin-bottom: 25px"><span class="price {{ $product->special_price > 0 ? 'has-discount' : '' }}">${{$product->price}}</span>&nbsp <span class="price">{{ $product->special_price > 0 ? '$'.$product->special_price : '' }}</span></div>
											@if(false)
												<div class="uk-text-center uk-padding-small">
													@if(!empty($product->getAttributesWithType(\App\ProductAttribute::TYPE_COLOR)))
														@foreach($product->getAttributesWithType(\App\ProductAttribute::TYPE_COLOR) as $attr)
															@foreach($attr->options as $option)
																<span class="color-option" style="background-color: {{$option->value}}"></span>
															@endforeach
														@endforeach
													@endif
												</div>
											@endif
											<div class="uk-flex uk-flex-center@m uk-flex-right@l uk-position-bottom" style="padding: 5px;">
												<span class="uk-icon-button uk-margin-small-right" uk-icon="heart"></span>
												<span class="uk-icon-button uk-margin-small-right" uk-icon="plus"></span>
											</div>
										</div>
										@endif

									</div>
								</div>
						@endforeach
					</div>

					{{-- product cards --}}
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	var cw = $('.product-image').width();
	$('.product-image').css({'height':cw+'px'});
</script>
@endif
@endsection