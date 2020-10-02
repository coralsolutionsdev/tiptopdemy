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
                    @if(true)
                    <table class="uk-table uk-table-divider uk-table-justify uk-table-middle uk-margin-remove ">
                        <thead>
                        <tr>
                            <th class="uk-table-expand">{{__('main.Order no.')}}</th>
                            <th class="uk-text-center">{{__('main.Purchasing date')}}</th>
                            <th class="uk-text-center">{{__('main.Items count')}}</th>
                            <th class="uk-text-center">{{__('main.Payment status')}}</th>
                            <th class="uk-text-center">{{__('main.Invoice')}}</th>
                        </tr>
                        </thead>
                        <tbody class="card-items">
                        @forelse($orders as $order)
                            <tr class="">
                                <td>
                                    <p class="uk-margin-remove uk-text-bold uk-text-primary">#{{$order->order_number}}</p>
                                </td>
                                <td class="uk-text-center"><p class="uk-margin-remove ">{{date_html($order->created_at)}}</p></td>
                                <td class="uk-text-center">{{$order->items->count()}}</td>
                                <td class="uk-text-center">
                                    <div class="uk-alert-{{$order->getStatusColor()}}" uk-alert style="padding: 10px">
                                        <p>{{__('main.'.$order->getStatus())}}</p>
                                    </div>
                                </td>
                                <td class="uk-text-center"><a class="uk-button uk-button-primary" target="_blank" href="{{route('invoice.show', $order->getInvoiceHashedID())}}">{{__('main.View invoice')}}</a></td>

                            </tr>
                        @empty
                            <tr>
                                <td>{{__('main.There is no form items yet.')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

