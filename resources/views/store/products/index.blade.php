@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <a href="{{Route('store.products.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('content')
    <section>
        {{--Page header--}}
        @include('manage.partials._page-header')

        {{--List of items--}}
        <div>
            <div class="card border-light table-card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" width="30">{{__('main.Cover image')}}</th>
                            <th scope="col">{{__('main.Product')}}</th>
                            <th scope="col" class="text-center">{{__('main.Type')}}</th>
                            <th scope="col" class="text-center">{{__('main.Quantity')}}</th>
                            <th scope="col" class="text-center">{{__('main.Price')}}</th>
                            <th scope="col" class="text-center">{{__('main.SKU')}}</th>
                            <th scope="col" class="text-center">{{__('main.Status')}}</th>
                            <th scope="col" class="text-center" width="350">{{__('main.Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td  class="text-center align-middle" style="width: 120px">
                                    <img src="{{$product->getProductPrimaryImage()}}" style="width: 100%">
                                </td>
                                <td  class="align-middle">
                                    <p><a href="{{route('store.products.edit', $product->slug)}}#lessons">{{ucfirst($product->name)}}</a></p>
                                    <p class="text-muted"><small>{{ucfirst($product->user->name)}} | {{$product->created_at->toFormattedDateString()}}</small></p>
                                    <p>{{substr(strip_tags($product->description),0,50)}} {{strlen($product->description) > 50 ? "...": "" }}</p>
                                </td>
                                <td class="text-center align-middle">{{ucfirst($product->type->name)}}</td>
                                <td class="text-center align-middle">{{ucfirst($product->quantity)}}</td>
                                <td class="text-center align-middle">{{ucfirst($product->price)}}</td>
                                <td class="text-center align-middle">{{ucfirst($product->sku)}}</td>
                                <td class="text-center align-middle">{!! $product->getStatus() !!}</td>
                                <td class="text-right align-middle">
                                    <div class="action_btn" style="padding-top: 25px">
                                        <ul>
                                            @if($product->type->id == 1)
                                            <li class="">
                                                <a href="{{route('store.products.edit', $product->slug)}}#lessons" class="btn btn-light">{{__('main.Lessons')}}</a>
                                            </li>
                                            @endif
                                            <li class="">
                                                <a target="_blank" href="{{route('store.product.show', $product->slug)}}" class="btn btn-light"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                            </li>
                                            <li class="">
                                                <a href="{{route('store.products.edit', $product->slug)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                            </li>
                                            <li class="">
                                                <span id="{{$product->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                <form id="delete-form" method="post" action="{{route('store.products.destroy', $product->slug)}}">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            {{$products->links()}}
        </div>
    </section>
@endsection
@section('script')
@endsection
