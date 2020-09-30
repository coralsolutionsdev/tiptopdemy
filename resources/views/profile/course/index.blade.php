@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $user->name)
@section('content')
    <div class="profile uk-container uk-margin-medium-bottom" style="background-color: transparent">
        {{--header--}}
        @include('partial.frontend._page-header')
        {{--body--}}
        <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-5 uk-visible@m">
                @include('profile.partials._sidebar')
            </div>
            {{--content--}}
            <div class="uk-width-expand">
                <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-padding-remove-top">
                    <table class="uk-table uk-table-divider uk-table-justify uk-table-middle uk-margin-remove ">
                        <thead>
                        <tr>
                            <th width="100" class="">{{__('main.Product image')}}</th>
                            <th class="">{{__('main.Product info')}}</th>
                            <th class="uk-text-center">{{__('main.Course period')}}</th>
                            <th class="uk-text-center">{{__('main.Achievement and development')}}</th>
                            <th class="uk-text-center">{{__('main.Efficiency')}}</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody class="card-items">
                        @forelse($products as $product)
                            <tr class="cart-item">
                                <td>
                                    <img data-src="{{$product->getProductPrimaryImage()}}" width="100" height="" alt="" uk-img>
                                </td>
                                <td>
                                    <p class="uk-margin-remove"><a target="_blank" href="{{route('store.product.show', $product->slug)}}">{{ucfirst($product->name)}}</a></p>
                                    <p class="uk-margin-remove" class="text-muted"><span><img class="uk-border-circle" src="{{$product->user->getProfilePicURL()}}" style="width: 20px; height: 20px; object-fit: cover"></span> <small><span>{{__('main.By')}}: </span> <span> {{$product->user->name}}</span></small></p>
                                </td>
                                <td class="uk-text-center">
                                   <span class="uk-margin-remove uk-text-primary uk-heading-small">60</span>{{trans_choice(__('main.Days'), 60)}}
                                    <p class="uk-margin-remove">{{__('main.Remaining')}}: <span class="uk-text-warning" style="font-size: 18px">10</span> {{trans_choice(__('main.Days'), 10)}}</p>

                                </td>
                                <td class="uk-text-center">
                                    <div style="padding-bottom: 6px"><span class="uk-margin-remove uk-heading-small"><span class="uk-text-success">1</span>/8</span>{{trans_choice(__('main._units'), 8)}}</div>
                                    <i class="fas fa-circle uk-text-success"></i>
                                    <i class="far fa-circle"></i>
                                    <i class="far fa-circle"></i>
                                    <i class="far fa-circle"></i>
                                    <i class="far fa-circle"></i>
                                    <i class="far fa-circle"></i>
                                    <i class="far fa-circle"></i>
                                </td>
                                <td class="uk-text-center">
                                    <span class="uk-margin-remove" style="font-size: 28px">%</span><span class="uk-text-success uk-heading-small">90</span>
                                </td>
                                <td class="uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
                                    <a class="uk-button uk-button-primary" href="{{route('store.product.show', $product->slug)}}"><span uk-icon="icon:  play-circle"></span> {{__('main.View lesson')}}</a>
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
        </div>
    </div>
@endsection

