@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('content')
    <section>
        @include('partial.frontend._page-header')
        <div class="uk-background-default pt-25">
            <div class="uk-container">
                <div uk-grid>
                    <div class="uk-width-1-2@m ">
                        {{-- Posts cards --}}
                        <div class="uk-child-width-1-1@m" uk-grid>
                            {{-- Image slider --}}
                            <div class="uk-position-relative product-images" uk-slideshow="animation: fade">

                                <ul class="uk-slideshow-items" style="height: 500px">
                                    @foreach($product->getImages() as $image)
                                    <li>
                                        <img class="product-image" src="{{asset($image->url)}}" alt="" uk-cover>
                                    </li>
                                    @endforeach
                                </ul>

                                <div class="uk-position-small uk-flex uk-flex-center">
                                    <ul class="uk-thumbnav">
                                        @foreach($product->getImages() as $key => $image)
                                            <li uk-slideshow-item="{{$key}}"><a href="#" class="product-image-thumb"><img src="{{asset($image->url)}}" width="100" alt=""></a></li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                            {{-- / Image slider --}}
                        </div>
                    </div>
                    <div class="uk-width-1-2@m blog-sidebar">
                        {{-- product info --}}
                        @if(!empty( $product->getTags()))
                            <div>
                                @foreach( $product->getTags() as $tag)
                                    <span class="uk-label">{{$tag}}</span>
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <h2 style="margin: 0px">{{$product->name}}</h2>
                            {!! subContent($product->description,150) !!}
                        </div>
                        <div>
                            <span uk-icon="star" style="color: var(--theme-primary-color)"></span>
                            <span uk-icon="star" style="color: var(--theme-primary-color)"></span>
                            <span uk-icon="star" style="color: var(--theme-primary-color)"></span>
                            <span uk-icon="star" style="color: var(--theme-primary-color)"></span>
                            <span uk-icon="star" style="opacity: 0.3;"></span>
                            <span>(0 reviews)</span>
                        </div>
                        <div class="product-price" style="margin-top: 15px"><h3><span style="color: var(--theme-primary-color)">${{$product->price}}</span></h3></div>

                        <div class="uk-grid-small uk-child-width-1-1@s uk-child-width-1-2@m" uk-grid>
                            @foreach($product->getAllProductAttr() as $attribute)
                                <div class="uk-width-1-4@m uk-text-capitalize">
                                   {{$attribute->name}}:
                                </div>
                                <div class="uk-width-3-4@m">
                                    @if($attribute->type == App\ProductAttribute::TYPE_RADIO)
                                    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
                                        @foreach ($attribute->options as $option)
                                            @if($product->getProductAttrOptionValueById($attribute->id, $option->id) == $option->value)
                                                <label><input class="uk-radio" type="radio" name="radiodfd1" value="{{ $option->value }}" {{$product->getProductAttrOptionValueById($attribute->id, $option->id) == $option->value ? 'checked' : '' }}> &nbsp {{$option->name}}</label>
                                            @endif
                                        @endforeach
                                    </div>
                                    @elseif($attribute->type == App\ProductAttribute::TYPE_CHECKBOX)
                                        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
                                            @foreach ($attribute->options as $option)
                                                <div>
                                                    <label><input class="uk-radio" type="radio" name="radio2" value="{{ $option->value }}"  {!! $product->hasAttributeValue($attribute->name, $option->value) ? '' : 'disabled'  !!}> &nbsp {{$option->name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($attribute->type == App\ProductAttribute::TYPE_TEXT_FIELD || $attribute->type == App\ProductAttribute::TYPE_TIMESTAMP)
                                        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
                                            <div>
                                                <label>{{$product->getProductAttrValue($attribute->name)}}</label>
                                            </div>
                                        </div>
                                    @elseif($attribute->type == App\ProductAttribute::TYPE_COLOR)
                                        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
                                            @foreach ($attribute->options as $option)
                                                @if($product->getProductAttrOptionValueById($attribute->id, $option->id) == $option->value)
                                                    <div>
                                                        <label><input class="uk-radio" type="radio" name="radio1" value="{{ $option->value }}"> &nbsp <span class="color-option" style="background-color: {{$option->value}}"></span></label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <div>

                                <div style="margin-top: 30px">
                                    <form>

                                        <div class="uk-margin quantity" uk-margin>
                                            <span class="uk-button uk-button-default quantity-button " style="background-color: #F5F5F5; width: 30px;"><</span>
                                            <div uk-form-custom="target: true" style="margin: -4px;">
                                                <input class="uk-input quantity-input" type="number" style="height: 39px; width: 60px; text-align: center; background-color: #F5F5F5" value="1">
                                            </div>
                                            <span class="uk-button uk-button-default quantity-button add" style="background-color: #F5F5F5; width: 30px;">></span>
                                            <span class="uk-button uk-button-primary add-to-cart">Add to cart</span>
                                            <span class="uk-button uk-button-default add-to-wish-list"><span uk-icon="icon: heart"></span></span>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div uk-grid>
                    <div class="uk-width-1-1@m">
                        <ul class="uk-subnav uk-flex-center" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium" uk-tab>
                            <li><a href="#">Description</a></li>
                            <li><a href="#">Information</a></li>
                            <li><a href="#">Reviews (0)</a></li>
                        </ul>

                        <ul class="uk-switcher uk-margin">
                            <li>
                                {!! $product->description !!}
                            </li>
                            <li>t is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum</li>
                            <li>No reviews!</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--Purshase module--}}
    <section>
        <!-- This is the modal -->
{{--        <div id="modal-example" class="uk-modal-container purchase-modal" uk-modal>--}}
        <div id="modal-example" uk-modal>
            <div class="uk-modal-dialog uk-margin-auto-vertical">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h5 class="uk-modal-title">Your shopping cart</h5>
                </div>
                <div class="uk-modal-body">
                    <p class="uk-text-success">
                        <i class="far fa-check-circle uk-margin-small-right"></i><span><span class="message-quantity"></span> new item(s) have been added to your cart</span>
                    </p>
                    <div uk-grid>
                        <div class="uk-width-1-3@m">
                            <div style="height: 120px; overflow: hidden">
                                <img src="http://baseapp.local/storage/images/products/2GGwRUoKZ2266GPtSCRIvR2xkJENMA1oBjSBNJmB.jpeg" alt="" >
                            </div>

                        </div>
                        <div class="uk-width-2-3@m">
                            <span class="uk-text-primary">{{$product->name}}</span>
                            <div class="uk-child-width-1-2@m" uk-grid style="padding-left: 20px">
                                <div style="padding: 0px; margin: 0px">Price:</div>
                                <div style="padding: 0px; margin: 0px" class="uk-text-right">${{$product->price}}</div>
                                <div style="padding: 0px; margin: 0px" class="">Quantity:</div>
                                <div style="padding: 0px; margin: 0px" class="uk-text-right modal-quantity">1</div>
                                <div style="padding: 0px; margin: 0px">Total:</div>
                                <div style="padding: 0px; margin: 0px" class="uk-text-right uk-text-success modal-total">${{$product->price}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-text-right">
                        <button class="uk-button uk-button-default uk-modal-close" type="button">Go to cart</button>
                        <button class="uk-button uk-button-primary" type="button">Check out</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('.add-to-cart').click(function () {
            @if(Auth::check())
            var quantity =  $('.quantity-input').val();
            var price = '{{$product->price}}';
            var total = price * quantity;
            $('.modal-quantity, .message-quantity').html(quantity);
            $('.modal-total').html('$'+total.toFixed(2));

            UIkit.modal('#modal-example').show();
            @else
            UIkit.modal('#login-modal').show();
            @endif
        });
    </script>
    <script>
        $('.quantity-button').click(function () {
            var item = $(this);
            var quantity_input = item.parent().find('.quantity-input');
            var quantity_input_val = quantity_input.val();
            if (item.hasClass('add')){
                quantity_input_val++;
            } else {
                if (quantity_input_val > 1){
                    quantity_input_val--;
                }
            }
            quantity_input.val(quantity_input_val);
        });
    </script>
@endsection
