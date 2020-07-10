<div class="widget uk-padding-small uk-box-shadow-hover-small p-tag-m-0">
    <div>
        <h4 class="">{{__('main.latest products')}}</h4>
        <span class="uk-text-meta">{{__('main.view the recently added products')}}. </span>
        <table class="uk-table uk-table-justify uk-table-divider">
            <thead>
            <tr>
                <th class="" width="100">{{__('main.Cover image')}}</th>
                <th>{{__('main.Product')}}</th>
                <th>{{__('main.Price')}}</th>
                <th>{{__('main.Status')}}</th>
                <th>{{__('main.Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $product)
            <tr>
                <td>
                    <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                        <img class="uk-transition-scale-up uk-transition-opaque" src="{{$product->getProductPrimaryImage()}}" alt="">
                    </div>
                </td>
                <td>
                    <p><a target="_blank" href="{{route('store.product.show', $product->slug)}}">{{ucfirst($product->name)}}</a></p>
                    <p class="text-muted"><small>{{ucfirst($product->user->name)}} | {{$product->created_at->toFormattedDateString()}}</small></p>
                    <p>{{subContent($product->description, 80)}}</p>
                </td>
                <td class="align-middle">{{ucfirst($product->price)}}</td>
                <td class="align-middle">{!! $product->getStatus() !!}</td>
                <td class="align-middle">
                    <a href="{{route('store.product.show', $product->slug)}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-success" uk-tooltip="{{__('main.view')}}"><i class="fas fa-eye" aria-hidden="true"></i></a>
                    <a href="{{route('store.products.edit', $product->slug)}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-primary" uk-tooltip="{{__('main.edit')}}"><span uk-icon="icon: pencil"></span></a>
                    <span id="{{$product->id}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger btn-delete" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                    <form id="delete-form" method="post" action="{{route('store.products.destroy', $product->slug)}}">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right" style="padding: 10px">
            <a href="{{Route('store.products.index')}}" class="uk-button uk-button-small uk-action-btn uk-button-default">{{__('main.view all')}}</a>
        </div>
    </div>
</div>