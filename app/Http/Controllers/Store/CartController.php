<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Shopping Cart';
        $this->breadcrumb = [
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title =  __('main.Cart');
        $breadcrumb = $this->breadcrumb + [
                __('main.Cart') => '',
                __('main.Products') => '',
            ];
//        foreach (Cart::content() as $rowId => $item){
//
//        }
//        Cart::remove('a775bac9cff7dec2b984e023b95206aa');
//        dd(Cart::content());
        return view('cart.index', compact('page_title', 'breadcrumb'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function add(Request $request)
    {
        $input = $request->only(['id', 'name', 'qty', 'price', 'image', 'sku']);
        Cart::add([
            'id' => $input['id'],
            'name' => $input['name'],
            'qty' => $input['qty'],
            'price' => $input['price'],
            'weight' => 0,
            'options' => [
                'image' => $input['image'],
                'sku' => $input['sku'],
            ]
        ]);
        $cart = [
            'item_count' => Cart::content()->count(),
            'subtotal' => Cart::subtotal(),
            'grand_total' => Cart::priceTotal(),
        ];
        return response($cart, 200);
    }

    public function destroyItem(Request $request)
    {
        $rowID = $request->id;
        Cart::remove($rowID);
        $cart = [
            'item_count' => Cart::content()->count(),
            'subtotal' => Cart::subtotal(),
            'grand_total' => Cart::priceTotal(),
        ];
        return response($cart, 200);
    }
}
