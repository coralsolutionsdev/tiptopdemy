<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Store\Invoice;
use App\Modules\Store\Order;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $hashedId
     * @return void
     */
    public function show($hashedId)
    {
        $invoiceInfo = Invoice::decodeHashedId($hashedId);
        if (!isset($invoiceInfo['invoice_id']) || empty($invoiceInfo['invoice_id'])){
            abort(404);
        }
        $invoice = Invoice::find($invoiceInfo['invoice_id']);
        $order = Order::find($invoiceInfo['order_id']);
        return view('invoices.frontend.show', compact('invoice', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
