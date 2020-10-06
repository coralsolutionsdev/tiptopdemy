<!DOCTYPE html>
<html lang="en" dir="{{getLanguage() == 'ar'? 'rtl': ''}}">
<head>
    <title>Invoice: #{{$invoice->invoice_number}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset_image('/assets/favicon/favicon.ico')}}" type="image/x-icon">
    <!--UiKit UI-->
    @if(getLanguage() == 'ar')
        <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit-rtl.min.css')}}"/>
    @else
        <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit.min.css')}}"/>
    @endif
    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">{{--    <!--Semantic UI-->--}}

    <style>
        html, body{
            background-color: #F9F8FD;
            font-size: 12px;
            font-family: 'Cairo';
        }
        h1, h2, h3, h4, h5, p{
            font-family: 'Cairo';
        }
        .bg-secondary{
            background-color: #F9F8FD;
        }
        *+address, *+dl, *+fieldset, *+figure, *+ol, *+p, *+pre, *+ul {
            margin-top: 0px;
            color: #828691;
        }
        .uk-table td, .uk-table th {
            padding: 5px;
            vertical-align: top;
            color: #828691;
        }
        p {
            color: #1F2229;
        }
        .uk-text-muted{
            color: #828691;
        }
        .uk-text-success{
            color: #32d296;
        }
        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
</head>
<body>
<div id="invoice"  class="uk-section">
    <div class="uk-container uk-container-small">
        <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
            <div class="uk-padding-large bg-secondary">
                <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-3-4">
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-auto"><img src="{{asset_image(getSite()->logo)}}" style="height: 75px" alt=""></div>
                            <div class="uk-width-auto uk-flex uk-flex-middle">
                                <div>
                                    <h2 class="uk-margin-remove uk-text-bold">Tiptop Academy</h2>
                                    <p class="uk-margin-remove uk-text-muted">sales@tiptopdemy.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-auto uk-flex-middle">
                        <div>
                            <p class="uk-margin-remove uk-text-bold" style="font-size: 38px">{{__('main.Invoice')}}</p>
                            <p class="uk-margin-remove">{{__('main.Invoice No')}}: <span class="uk-text-muted">#{{$invoice->invoice_number}}</span></p>
                            <p class="uk-margin-remove">{{__('main.Invoice Date')}}: <span class="uk-text-muted">{{date_html($invoice->created_at)}}</span></p>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <div class="" style="padding-top: 20px">
                            <h3 class="uk-margin-remove">{{__('main.Recipient')}}</h3>
                            <p class="uk-margin-remove uk-text-muted">{{$invoice->customer_name}}</p>
                            <p class="uk-margin-remove uk-text-muted">{{$invoice->billing_address}}</p>
                            <p class="uk-margin-remove uk-text-muted">{{$invoice->billing_city}} {{$invoice->billing_country}}</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="uk-padding-large">
                <table class="uk-table uk-table-divider uk-table-middle" style="margin:0px;">
                    <thead>
                    <tr>
                        <th class="uk-width-2-3">{{__('main.Item description')}}</th>
                        <th class="">{{__('main.Unit Price')}}</th>
                        <th class="uk-text-center">{{__('main.Qty.')}}</th>
                        <th class="uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">{{__('main.Total')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="">
                                    <p class="uk-margin-remove uk-text-bold">{{$item->title}}</p>
                                    <p class="uk-margin-remove item-description">{!! $item->description !!}</p>
                                </td>
                                <td class="">{{$item->unit_price}} <span class="uk-text-primary">USD</span></td>
                                <td class="uk-text-center">{{$item->quantity}}</td>
                                <td class="uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">{{$item->total_price}} <span class="uk-text-primary">USD</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-2-3"></div>
                    <div class="uk-width-expand uk-grid-collapse">
                        <div class="uk-grid-collapse" uk-grid style="border-top: 1px solid #D8D8D8;  padding: 10px 5px; margin-bottom: 10px">
                            <div class="uk-width-1-2"><p class="uk-margin-remove">{{__('main.Subtotal')}}</p></div>
                            <div class="uk-width-1-2 uk-text-muted uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">{{$invoice->subtotal}}</div>
                        </div>
                        <div class="uk-grid-collapse" uk-grid style="border-top: 1px solid #D8D8D8;  padding: 10px 5px; margin-bottom: 10px">
                            <div class="uk-width-1-2"><p class="uk-margin-remove">{{__('main.Discount')}}</p></div>
                            <div class="uk-width-1-2 uk-text-muted uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">{{$invoice->discount_amount}}</div>
                        </div>
                        <div class="uk-grid-collapse" uk-grid style="border-top: 1px solid #D8D8D8;  padding: 10px 5px; margin-bottom: 10px">
                            <div class="uk-width-1-2"><p class="uk-margin-remove">{{__('main.Grand Total')}}</p></div>
                            <div class="uk-width-1-2 uk-text-muted uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}} "><h3 class="uk-text-primary">{{$invoice->grand_total}} USD</h3></div>
                        </div>
                        <div class="uk-padding-small uk-text-center">
                            <div class="uk-alert-{{$order->getStatusColor()}}" uk-alert style="padding: 10px">
                                <p class="uk-text-success">{{__('main.'.$order->getStatus())}}</p>
                            </div>
                            <button class="uk-button uk-button-primary uk-width-1-1 no-print" onclick="printDiv()"><span uk-icon="icon: print"></span> {{__('main.Print invoice')}}</button>

                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</div>

<script>
    function printDiv(){
        var printContents = document.getElementById('invoice').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

    }
</script>

</body>
</html>