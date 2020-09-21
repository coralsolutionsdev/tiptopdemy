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
	<div class="store uk-container" style="background-color: transparent">
	{{--header--}}
		@include('store.products.frontend._page_header')
	{{--body--}}
		{!! Form::open(['url' => route('cart.place.order'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
		<div class="uk-grid-small uk-child-width-1-1 uk-margin-medium-bottom" uk-grid>
			<div>
				<div class="uk-grid-small" uk-grid>
					<div class="uk-width-expand">
						<div class="uk-card uk-card-default uk-card-body uk-padding-small">
							<h5 class="text-highlighted uk-margin-small uk-text-bold">{{__('main.Cart items')}} (<span class="cart-count">{{Cart::content()->count()}}</span>)</h5>
							<table id="cart-table" class="uk-table uk-table-divider uk-table-justify uk-table-middle uk-margin-remove ">
								<thead>
								<tr>
									<th width="100" class="">{{__('main.Product image')}}</th>
									<th colspan="">{{__('main.Product info')}}</th>
									<th class="uk-table-shrink">{{__('main.Quantity')}}</th>
									<th class="uk-table-shrink">{{__('main.Price')}}</th>
									<th class="uk-table-shrink">{{__('main.Delete')}}</th>
								</tr>
								</thead>
								<tbody class="card-items">
								@forelse(Cart::content() as $rowId => $item)
								<tr class="cart-item">
									<td>
										<img data-src="{{$item->options['image']}}" width="100" height="" alt="" uk-img>
									</td>
									<td>
										<p class="uk-margin-remove uk-text-bold">{{$item->name}}</p>
										<p class="uk-margin-remove">{{$item->options['sku']}}</p>
									</td>
									<td class="uk-text-center">
										<p class="uk-margin-remove">{{$item->qty}}</p>
									</td>
									<td class="uk-text-center">
										<p class="uk-margin-remove"><span class="uk-text-primary">$</span>{{$item->price}}</p>
									</td>
									<td class="uk-text-center">
										<span id="{{$rowId}}" class="uk-text-danger btn-delete delete-cart-item" uk-icon="icon: trash; ratio: 1"  uk-tooltip="title: {{__('main.delete')}}"></span>
									</td>
								</tr>
								@empty
									<tr>
										<td>{{__('main.There is no form items yet.')}}</td>
									</tr>
								@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="uk-width-1-4 uk-visible@m">
						<div class="uk-card uk-card-default uk-card-body uk-padding-small">
							<div class="uk-grid-small" uk-grid>
								<div class="uk-width-1-1">
									<h5 class="text-highlighted uk-text-bold">{{__('main.Cart summary')}}</h5>
								</div>
								<div class="uk-width-1-2">{{__('main.Subtotal')}}:</div>
								<div class="uk-width-1-2 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}} cart-subtotal">${{Cart::subtotal()}}</div>
{{--								<div class="uk-width-2-3"><input class="uk-input uk-form-small" name="discount_coupon" type="text" placeholder="{{__('main.Put discount coupon')}}"></div>--}}
{{--								<div class="uk-width-1-3 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}"><button class="uk-button uk-button-success uk-button-small uk-width-1-1">{{__('main.Apply')}}</button></div>--}}
								<div class="uk-width-1-2">{{__('main.Discount')}}:</div>
								<div class="uk-width-1-2 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">%0</div>
								<div class="uk-width-1-2">{{__('main.Grand Total')}}:</div>
								<div class="uk-width-1-2 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}"><h2 class="uk-text-bold"><span class="uk-text-primary">$</span><span class="cart-grand-total">{{Cart::priceTotal()}}</span></h2></div>
								<div class="uk-width-1-1">
									<h5 class="text-highlighted uk-text-bold" >{{__('main.Pay by')}}</h5>
								</div>
								<div class="uk-width-1-2">
									<label><input class="uk-radio" type="radio" name="pay_by" value="1" checked> {{__('main.Tiptop credits')}}:</label>
								</div>
								<div class="uk-width-1-2 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
									<img data-src="{{asset_image('/assets/payment/tiptop.png')}}" width="75" height="" alt="" uk-img>
								</div>
								<div class="uk-width-1-2">
									<label><input class="uk-radio" type="radio" name="pay_by" value="2"> {{__('main.Credit card')}}:</label>
								</div>
								<div class="uk-width-1-2 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
									<img data-src="{{asset_image('/assets/payment/visa.png')}}" width="75" height="" alt="" uk-img>
								</div>
								<div class="uk-width-1-2">
									<label><input class="uk-radio" type="radio" name="pay_by" value="3"> {{__('main.PayPal')}}:</label>
								</div>
								<div class="uk-width-1-2 uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
									<img data-src="{{asset_image('/assets/payment/paypal.png')}}" width="75" height="" alt="" uk-img>
								</div>
								<div class="uk-width-1-1">
									<button class="uk-button uk-button-primary uk-width-1-1  uk-margin-small-top">{{__('main.Place Order')}}</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	@include('partial.scripts._cart')
@endsection