@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <style>
    </style>
@endsection
@section('content')
    <section>
        {{--Header--}}
        <div class="">
            <div class="uk-container" style="padding-bottom: 20px">
                <div class="product-header">
                    <div class="uk-grid-small" uk-height-match="target: > div > .uk-card; row: false" uk-grid>
                        <div class="nav-col" style="width: 5%">
                                <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#prev-form').submit()">
                                    <span uk-icon="icon: chevron-{{getFloatKey('end')}}"></span>
                                </div>
                            <form id="prev-form" method="GET" action="{{!empty($prevLesson) ? route('store.lesson.show', [$product->slug, $prevLesson->slug]) : route('store.lesson.show', [$product->slug, $lesson->slug])}}">
                            </form>
                        </div>
                        <div class="uk-width-expand@m">
                            <div class="uk-card uk-card-body uk-padding-small" style="background: linear-gradient(45deg,{{str_replace(['"', '[', ']'], '', json_encode($product->getColorPattern()->gradient))}}); color: #FFFFFF">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-4@m">
                                        <div class="uk-card uk-card-body uk-padding-small">
                                            <div class="thumbnail uk-border-circle" style="width: 200px; height: 200px; border: 7px solid rgba(255,255,255,0.4)">
                                                <img src="{{$product->getProductPrimaryImage()}}" class="portrait" alt="Image" width="200" height="200"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-expand@m uk-flex uk-flex-middle uk-text-{{getFloatKey('start')}}">
                                        <div class="uk-card uk-card-body uk-padding-small product-header-body">
                                            <h3 class="uk-text-bold" style="margin: 0px">{{$product->name}}</h3>
                                            <h4 class="uk-text-bold" style="margin: 0px">{{$lesson->title}}</h4>
                                            <p style="margin: 5px">{!! $product->description !!}</p>
                                            <p><strong>{{__('main.By')}}: </strong> {{$product->user->name}}</p>
                                            <div class="product-tags">
                                                @foreach($product->tagsWithType('product') as $tag)
                                                    <a class="uk-button uk-button-default" href="#">{{$tag->name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-4@m">
                                        <div class="uk-card uk-card-body uk-flex uk-flex-middle uk-padding-small uk-height-1-1" style="background-color: rgba(0,0,0,0.09)">
                                            <ul class="uk-list">
                                                <li><span uk-icon="icon: play-circle"></span> {{$product->lessons->count()}} {{__('main.lessons')}}</li>
                                                <li><span uk-icon="icon: file-text"></span> {{$product->groups->count()}} {{__('main.units')}}</li>
                                                <li><span uk-icon="icon: file-edit"></span> {{$product->lessons->where('type', \App\Modules\Course\Lesson::TYPE_QUIZ)->count()}} {{__('main.quizzes')}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-col" style="width: 5%">
                            <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#next-form').submit()">
                                <span uk-icon="icon: chevron-{{getFloatKey('start')}}"></span>
                            </div>
                            <form id="next-form" method="GET" action="{{!empty($nextLesson) ? route('store.lesson.show', [$product->slug, $nextLesson->slug]) : route('store.lesson.show', [$product->slug, $lesson->slug])}}">
                            </form>
                        </div>
                    </div>

                </div>
                <div style="padding-top: 20px ">
                    <ul class="breadcrumb">
                        <li>
                            <span uk-icon="home"></span>
                        </li>
                        @foreach($breadcrumb as $page => $link)
                            <li><a href="">{{__($page)}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{--Header end--}}
        <div class="uk-background-default pt-25">
            <div class="uk-container">
                <div class="uk-margin" uk-grid>
                    <div class="uk-width-1-4@m">
                        {{--Purshase--}}
                        <div class="uk-card uk-margin-small uk-card-body uk-secondary-bg" style="padding: 20px">
                            <div class="uk-margin-small">
                                <div class="uk-grid-small">
                                    <div class="price"><span><h2 class="uk-text-primary uk-text-bold">$ {{$product->price}}</h2></span></div>
                                    <div>
                                        <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">{{__('main.Add to cart')}}</button>
                                    </div>
                                    <div>
                                        <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">{{__('main.Buy now')}}</button>
                                    </div>
                                    <div>
                                        <h5 class="uk-text-primary">{{__('main.This course includes')}}</h5>
                                        <ul class="uk-list">
                                            <li><span uk-icon="icon: file-text"></span> 0 {{__('main.downloadable resources')}}</li>
                                            <li><span uk-icon="icon: unlock"></span> {{__('main.Full lifetime access')}}</li>
                                            <li><span uk-icon="icon: file-edit"></span> {{$product->lessons->where('type', \App\Modules\Course\Lesson::TYPE_QUIZ)->count()}} {{__('main.quizzes')}}</li>
                                            <li><span uk-icon="icon: bookmark"></span> {{__('main.Certificate of Completion')}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Purshase end--}}
                        {{--Groups--}}
                        <div class="uk-card uk-margin-small uk-card-body" style="padding: 0px">
                            <div class="uk-margin-small">
                                <ul uk-accordion="multiple: true">
                                    @php
                                    $lessonCount = 0;
                                    @endphp
                                    @foreach($product->groups as $id => $group)
                                    <li class="{{$id == 0 ? 'uk-open' : ''}}" style="margin:0px 0px 10px 0px">
                                        <a class="uk-accordion-title uk-secondary-bg" style="padding: 10px 20px" href="#">{{sprintf('%02d', $id+1)}} | {{$group->title}}</a>
                                        <div class="uk-accordion-content">
                                            @foreach($group->items as $itemId => $item)
                                                @php
                                                    $lessonCount++;
                                                @endphp
                                                <a href="{{route('store.lesson.show', [$product->slug, $item->slug])}}">
                                                <div class="uk-secondary-bg-hover">
                                                    <div class="uk-grid-small uk-padding-small" uk-grid>
                                                        <div class="uk-width-1-5@s uk-text-center uk-flex uk-flex-middle">
                                                            @if($item->id == $lesson->id)
                                                                <span class="uk-border-circle uk-secondary-bg" style=" padding: 0px; color: {{$product->getMainColorPattern()}}"><span uk-icon="icon:   {{$lesson->type == \App\Modules\Course\Lesson::TYPE_PRESENTATION ? 'play-circle; ratio: 2' : 'pencil; ratio: 2'}}"></span></span>
                                                            @else
                                                                <span class="uk-border-circle uk-secondary-bg" style=" padding: 10px 12px">{{sprintf('%02d', $lessonCount)}}</span>
                                                            @endif
                                                        </div>
                                                        <div class="uk-width-4-5@s">
                                                            <div>
                                                                <p style="padding: 0px; margin: 0px">{{$item->title}}</p>
                                                                <p style="padding: 0px; margin: 0px" class="uk-flex uk-flex-middle"><span uk-icon="icon: clock; ratio: 0.6"></span> <span style="font-size: 13px; margin: 0 5px">3:00</span>  </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{--Groups end--}}
                    </div>
                    <div class="uk-width-expand@m">
                        @if($lesson->type == \App\Modules\Course\Lesson::TYPE_PRESENTATION)
                        <div class="iframe-container" style="padding-bottom: 15px">
                            {{--here--}}
                            @if($media = $lesson->media)
                                @foreach($media as $mediaItem)
                                    <div class="" style="margin-bottom: 5px">
                                        @if($mediaItem->type == \App\Modules\Media\Media::TYPE_VIDEO)
                                            <div class="uk-cover-container" style="height: 300px">
                                                <iframe class="frame" src="https://www.youtube.com/embed/_cAJ9VE2Mg8?autoplay=1&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent" width="560" height="315" frameborder="0" allowfullscreen uk-cover></iframe>
                                            </div>
{{--                                            <iframe width="560" height="315" src="https://www.youtube.com/embed/_cAJ9VE2Mg8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
{{--                                            <iframe class="frame" width="560" height="315" src="{{str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'], 'https://www.youtube.com/embed/', $mediaItem->source)}}" frameborder="0" allow="autoplay" allowfullscreen></iframe>--}}
                                        @else
                                            <iframe class="frame-w" allowfullscreen width="889" height="450" src="{{$mediaItem->source}}" frameborder="0"></iframe>
                                        @endif

                                    </div>
                                @endforeach
                            {{--here--}}
                            @endif
                            <br>

                            <script>
                                $(function() {
                                    var ifr = $(".frame");
                                    ifr.attr("scrolling", "no");
                                    ifr.attr("src", ifr.attr("src"));
                                    var newItemWidth = parseInt($('.iframe-container').width());
                                    console.log(newItemWidth, newItemHeight);
                                    var itemHeight = ifr.attr("height");
                                    var itemWidth = ifr.attr("width");
                                    var r = (itemWidth / newItemWidth) * 100;
                                    var newItemHeight = (itemHeight * 100) / r;
                                    ifr.attr("width",newItemWidth);
                                    ifr.attr("height",newItemHeight);
                                });
                            </script>

                       </div>
                        @elseif($lesson->type == \App\Modules\Course\Lesson::TYPE_QUIZ)
                            <div>
                                @forelse($lesson->getAvailableForms() as $form)
                                    <div class="uk-placeholder uk-text-center">
                                        <img src="{{asset_image('/assets/book_lover.png')}}" width="300">
                                        <br>
                                        <p style="font-size: 22px">{{$form->title}}</p>
                                        <p>{!! $form->description !!}</p>
                                        <a class="uk-button uk-button-primary" href="{{route('store.form.show',[$lesson->slug, $form->hash_id])}}">{{__('main.Take the exam')}}</a>

                                    </div>
                                @empty
                                    <div class="uk-placeholder uk-text-center bg-white uk-text-meta items-message">
                                        {{__('main.There is no form items yet.')}}.
                                    </div>
                                @endforelse
                            </div>
                        @endif
                        <div class="uk-grid-small uk-child-width-1-1@s" uk-grid>
                            <div>
                                <div class="uk-card uk-body uk-secondary-bg uk-padding-small">
                                    <span style="font-size: 18px">{{__('main.Lesson description')}}</span>
                                </div>
                            </div>
                            <div>
                                {!! $lesson->description !!}
                            </div>
                        </div>

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
{{--                                <img src="http://baseapp.local/storage/images/products/2GGwRUoKZ2266GPtSCRIvR2xkJENMA1oBjSBNJmB.jpeg" alt="" >--}}
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
