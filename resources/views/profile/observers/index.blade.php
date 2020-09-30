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
                    <div class="uk-padding">
                        <div class="uk-alert-warning uk-text-center" uk-alert>
                            <p>
                                This page is under development process.
                            </p>
                        </div>
                    </div>
                    @if(false)
                    <table class="uk-table uk-table-divider uk-table-justify uk-table-middle uk-margin-remove ">
                        <thead>
                        <tr>
                            <th class="uk-table-expand">{{__('main.Order info')}}</th>
                            <th class="">{{__('main.Payment status')}}</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody class="card-items">
                        @forelse($orders as $order)
                            <tr class="">
                                <td>s</td>
                                <td>s</td>
                                <td>s</td>
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

