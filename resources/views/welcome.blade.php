@extends('themes.'.getFrontendThemeName().'.v2.layout')
@section('title', 'Home')
@section('content')
    @if(!empty($layout))
        @foreach($layout->structure as $item)
            @if(!empty(getWidgetName($item)))
            @widget('home.'.getWidgetName($item),['items' => $item])
            @endif
        @endforeach
    @else
        <section class="">
            <div class="uk-container">
                <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slideshow="autoplay: true" style="overflow: hidden">

                    <ul class="uk-slideshow-items">
                        <li>
                            <img class="uk-visible@m" src="{{asset_image('/assets/slides/01.png')}}" alt="" uk-cover>
                            <div class="uk-position-center uk-position-small uk-padding">
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <h1 class="uk-text-bold text-highlighted uk-margin-small" uk-slideshow-parallax="y: -50,0,0; opacity: 1,1,0">
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
                                    <h1 class="uk-text-bold text-highlighted uk-margin-small" uk-slideshow-parallax="y: -50,0,0; opacity: 1,1,0">
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
                            <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-2@s uk-text-center" uk-grid uk-height-match="target: > div > .uk-card" uk-grid uk-scrollspy="cls: uk-animation-slide-bottom; target: .uk-card; delay: 300; repeat: true">
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
                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large"  uk-scrollspy-class="uk-animation-slide-top">
                                        <i class="fas fa-laptop-code fa-4x uk-margin-small-bottom" style="color: #17e5b4"></i>
                                        <p class="uk-margin-small uk-text-bold">أدوات التقييم</p>
                                        <p class="uk-margin-remove">
                                            تسلسل وتنوع أدوات التقييم، ومناسبتها لأعمال المتدربين التي يجري تقييمها.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large"  uk-scrollspy-class="uk-animation-slide-top">
                                        <i class="fas fa-map-signs fa-4x uk-margin-small-bottom" style="color: #fc788f"></i>
                                        <p class="uk-margin-small uk-text-bold">نظام إرشادي</p>
                                        <p class="uk-margin-remove">
                                            توفير التعليمات عن كيفية البدء باستخدام المقرّر الإلكتروني، وتعريف الأقسام الأساسية ونقطة البداية فيه.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-large" >
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
                               <h3 class="uk-text-primary uk-margin-remove uk-text-bold uk-margin-small">خدماتنا</h3>
                               <h4 class="text-highlighted uk-margin-remove uk-text-bold uk-margin-small">التحسين المستمر من خلال قياس إنجاز المتدربين ورضاهم باستخدام تقنيات موثوقة للتقييم.</h4>
                               <p>
                                   توفير إمكانية تقييم المتعلم للمحتوى الرقمي، وإضافته تعليقات على المحتوى مع توفير نظام دخول موحّد وآمن للتحقق من هوية المستفيد وضمان عدم تشتت فكره واضاعة وقته بما لاحاجة له في مرحلة التعليمية, توفير تطبيقات على الهواتف الذكية لأنظمة التعليم والتدريب الإلكتروني.
                               </p>
                               <a class="uk-button uk-button-primary uk-margin-small" href="">تعرف على المزيد</a>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-container uk-padding">
                <div class="uk-text-center">
                    <h3 class="uk-text-primary uk-margin-remove uk-text-bold uk-margin-small">آخر الدروس</h3>
                    <p class="uk-margin-small">
                        آخر الدروس المضافة
                    </p>
                </div>
                <div class="uk-margin uk-flex uk-flex-center" uk-grid>
                    <div class="uk-width-4-5@m uk-width-1-1@s">
                        <product-items per-page="3" ></product-items>
                    </div>
                </div>
            </div>
            <div class="uk-background-primary">
                <div class="uk-container uk-flex uk-flex-center">
                    <img src="{{asset_image('/assets/slides/03.png')}}" alt="">
                </div>
            </div>
        </section>

    @endif
@endsection