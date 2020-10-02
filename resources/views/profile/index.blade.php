@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $user->name)
@section('content')
    <div class="profile uk-container uk-margin-medium-bottom" style="background-color: transparent">
        {{--header--}}
        @include('partial.frontend._page-header')
        {{--body--}}
        <div class="uk-grid-small uk-padding-remove" uk-grid>
            <div class="uk-width-1-5 uk-visible@m">
                @include('profile.partials._sidebar')
            </div>
            {{--content--}}
            <div class="uk-width-expand"    >
                <div class="uk-grid-small uk-width-1-1" uk-grid uk-height-match="target: > div > .widget; row: false" style="padding-top: 1em">
                        <div class="uk-width-1-2@m">
                            <div class="widget uk-box-shadow-hover-small" style="border-radius: 15px; background-color: #FFF4DE; border-color: #FFF4DE; min-height: 14em">
                                <div class="" uk-grid>
                                    <div class="uk-width-1-4">
                                        <img src="{{asset_image('/assets/welcome-boss.svg')}}" style="width: 170px; position: absolute; margin-top: -58px">
                                    </div>
                                    <div class="uk-width-3-4" style="padding:2em 5em">
                                        <h3 class="uk-margin-remove"  style="color: #FFA800">{{__('main.welcome back')}} !!</h3>
                                        <p class="uk-margin-remove"> {{getAuthUser()->name}}</p>
                                        <br>
                                        <p class="uk-margin-remove uk-text-warning uk-text-bold">حكمة اليوم:</p>
                                        <p class="uk-margin-remove"> "ما أشرقت في الكون أي حضارة إلا و كانت من ضياء معلم"</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m">
                            <div class="widget uk-box-shadow-hover-small" style="border-radius: 15px; background-color:white; border-color: #FFF4DE; min-height: 14em">
                                <div class="" uk-grid>
                                    <div class="uk-width-1-2 ">
                                        <img src="{{asset_image('/assets/Studying-rafiki.png')}}" style="position: absolute; width: 260px; margin-top: -35px; margin-right: -25px">
                                    </div>
                                    <div class="uk-width-1-2" style="padding:2em">
                                        <h3 class="uk-margin-remove uk-text-success">{{__('main.My Courses')}}</h3>
                                        <p class="uk-margin-remove"> يوجد لديك <span class="uk-text-success" style="font-size: 28px">{{$user->getCourses(\App\Product::TYPE_COURSES)->count()}}</span> كورسات متاحة</p>
                                        <br>
                                        <a class="uk-button uk-button-default uk-button-gray" href="{{route('profile.courses.index')}}">{{__('main.View more')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m">
                            <div class="widget uk-box-shadow-hover-small" style="border-radius: 15px; background-color:white; border-color: #FFF4DE; min-height: 14em">
                                <div class="" uk-grid>
                                    <div class="uk-width-1-2 ">
                                        <img src="{{asset_image('/assets/Wallet-pana.png')}}" style="position: absolute; width: 280px; margin-top: -30px; margin-right: -20px">
                                    </div>
                                    <div class="uk-width-1-2" style="padding:2em">
                                        <h3 class="uk-margin-remove uk-text-danger">رصيدي</h3>
                                        <p class="uk-margin-remove"> يوجد لديك <span class="uk-text-danger" style="font-size: 28px">0.0$</span> في محفظتك</p>
                                        <br>
{{--                                        <a class="uk-button uk-button-default uk-button-gray" href="{{route('profile.courses.index')}}">{{__('main.View more')}}</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2@m">
                            <div class="widget uk-box-shadow-hover-small" style="border-radius: 15px; background-color:white; border-color: #FFF4DE; min-height: 14em">
                                <div class="" uk-grid>
                                    <div class="uk-width-1-2 ">
                                        <img src="{{asset_image('/assets/Telecommuting-pana.png')}}" style="position: absolute; width: 250px; margin-top: -15px; margin-right: -12px">
                                    </div>
                                    <div class="uk-width-1-2" style="padding:2em">
                                        <h3 class="uk-margin-remove uk-text-primary">الزيارات</h3>
                                        <p class="uk-margin-remove"> انت الزائر رقم <span class="uk-text-primary" style="font-size: 28px">33</span> من مجموع 4500 طالب</p>
                                        <br>
{{--                                        <a class="uk-button uk-button-default uk-button-gray" href="{{route('profile.courses.index')}}">{{__('main.View more')}}</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
@endsection

