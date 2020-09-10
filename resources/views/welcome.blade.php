@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', 'Home')
@section('content')
    @if(!empty($layout))
        @foreach($layout->structure as $item)
            @if(!empty(getWidgetName($item)))
            @widget('home.'.getWidgetName($item),['items' => $item])
            @endif
        @endforeach
    @else
        <section>
            <div class="uk-container">
                <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slideshow="autoplay: true" style="overflow: hidden">

                    <ul class="uk-slideshow-items">
                        <li>
                            <img class="uk-visible@m" src="{{asset_image('/assets/slides/01.png')}}" alt="" uk-cover>
                            <div class="uk-position-center uk-position-small uk-padding">
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h1 class="uk-text-bold text-highlighted" uk-slideshow-parallax="y: -50,0,0; opacity: 1,1,0">
                                        إمكانية استخدام المنصة على مختلف أنواع <span style="color: #17e5b4">الأجهزة</span> الرقمية

                                    </h1>
                                    <p class="uk-margin-remove" uk-slideshow-parallax="y: 50,0,0; opacity: 1,1,0">
تدعم  تصفحها على مختلف أنواع الأجهزة الرقمية باختلاف أنظمة تشغيلها وأحجام شاشاتها، بما في ذلك الهواتف الذكية والأجهزة اللوحيّة. لعرض المحتوى الرقمي بأشكال مختلفة (نصوص ومواد سمعيّة، ومواد مرئية) أي بطرق سمعية وبصرية متعددة لدعم احتياجات وخيارات المتعلم المتنوعة.
                                    </p>
                                </div>
                            </div>
                        </li>
                        {{--slide 2--}}
                        <li>
                            <img class="uk-visible@m" src="{{asset_image('/assets/slides/02.png')}}" alt="" uk-cover>
                            <div class="uk-position-center uk-position-small uk-padding">
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h1 class="uk-text-bold text-highlighted" uk-slideshow-parallax="y: -50,0,0; opacity: 1,1,0">
                                        تهتم <span style="color: #17e5b4">بتفاعل</span>  أصحاب المصلحة
                                    </h1>
                                    <p class="uk-margin-remove" uk-slideshow-parallax="y: 50,0,0; opacity: 1,1,0">
                                        تزويد أصحاب المصلحة (في البرنامج) بنتائج التقييم. حيث توفر أنظمة تحليل البيانات وإمكانية تتبّع تفاعل المتعلم مع أقرانه، ومع المحتوى والمعلم وولي الأمر. الذي يوفر للمتدرب التقييم الذاتي للتحقق من تقدمه في التعليم ، ويوفر له تغذية راجعة على المهام المُنجزة بشكل مستمر.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

                </div>
            </div>
            <div class="bg-white">
                <div class="uk-container uk-padding">
                    <div class="uk-child-width-1-2@m" uk-grid>
                        <div class="uk-width-1-2@m uk-width-1-1@s">
                            <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-2@s uk-text-center" uk-grid uk-height-match="target: > div > .uk-card">
                                <div>
                                    <div class="uk-card uk-card-primary uk-card-body uk-box-shadow-hover-large">
                                        <i class="fas fa-diagnoses fa-4x uk-margin-small-bottom"></i>
                                        <p class="uk-margin-small uk-text-bold">تقييم المحتوى</p>
                                        <p class="uk-margin-remove">
                                            توفير إمكانية تقييم المتعلم للمحتوى الرقمي، وإضافته تعليقات على المحتوىتوفير إمكانية تقييم المتعلم للمحتوى.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large">
                                        <i class="fas fa-laptop-code fa-4x uk-margin-small-bottom" style="color: #17e5b4"></i>
                                        <p class="uk-margin-small uk-text-bold">أدوات التقييم</p>
                                        <p class="uk-margin-remove">
                                            تسلسل وتنوع أدوات التقييم، ومناسبتها لأعمال المتدربين التي يجري تقييمها.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large">
                                        <i class="fas fa-map-signs fa-4x uk-margin-small-bottom" style="color: #fc788f"></i>
                                        <p class="uk-margin-small uk-text-bold">نظام إرشادي</p>
                                        <p class="uk-margin-remove">
                                            توفير التعليمات عن كيفية البدء باستخدام المقرّر الإلكتروني، وتعريف الأقسام الأساسية ونقطة البداية فيه.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large">
                                        <i class="fas fa-download fa-4x uk-margin-small-bottom" style="color: #ffb228"></i>
                                        <p class="uk-margin-small uk-text-bold">محتوى قابل للتنزيل</p>
                                        <p class="uk-margin-remove">
                                            توفير نسخ قابلة للتنزيل من كامل المحتوى الرقمي المستخدم داخل المقرّر الإلكتروني، على أن يتم استخدامها وفق حقوق الملكية الفكرية
                                        </p>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="uk-flex uk-flex-middle uk-width-expand">
                           <div>
                               <h3 class="uk-text-primary uk-margin-remove uk-text-bold">خدماتنا</h3>
                               <h4 class="text-highlighted uk-margin-remove uk-text-bold">التحسين المستمر من خلال قياس إنجاز المتدربين ورضاهم باستخدام تقنيات موثوقة للتقييم.</h4>
                               <p>
                                   توفير إمكانية تقييم المتعلم للمحتوى الرقمي، وإضافته تعليقات على المحتوى مع توفير نظام دخول موحّد وآمن للتحقق من هوية المستفيد وضمان عدم تشتت فكره واضاعة وقته بما لاحاجة له في مرحلة التعليمية, توفير تطبيقات على الهواتف الذكية لأنظمة التعليم والتدريب الإلكتروني.
                               </p>
                               <a class="uk-button uk-button-primary" href="">تعرف على المزيد</a>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-container uk-padding">
                <div class="uk-text-center">
                    <h3 class="uk-text-primary uk-margin-remove uk-text-bold">آخر الدروس</h3>
                    <p class="uk-margin-remove">
                        آخر الدروس المضافة
                    </p>
                </div>
                <div class=" uk-child-width-1-1 uk-margin uk-flex uk-flex-center" uk-grid>
                    <div class="uk-width-3-4@m uk-width-1-1@s">
                        @php
                            $products = \App\Product::latest()->get()->take(3);
                        @endphp
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
                                                <div class="uk-grid-collapse uk-text-center" style="position: absolute; width: 90%; margin-top: -40px;" uk-grid>
                                                    <div class="uk-width-expand"></div>
                                                    <div class="uk-width-auto">
                                                        <div class="uk-card uk-card-default uk-card-body" style="padding:3px 10px; color: black; font-weight: 700; font-size: 18px">
                                                            <span class="uk-text-primary">$</span> {{$product->price}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-weight: 700; color: black">{{$product->name}}</div>
                                                <div style="height: 50px">
                                                    {!! subContent($product->description, 130) !!}
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
                    </div>
                </div>
            </div>
            <div class="uk-background-primary">
                <div class="uk-container uk-text-center">
                    <img src="{{asset_image('/assets/slides/03.png')}}" alt="">
                </div>
            </div>
        </section>

    @endif
@endsection