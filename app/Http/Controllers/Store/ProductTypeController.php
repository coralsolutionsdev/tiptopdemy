<?php

namespace App\Http\Controllers\Store;

use App\ProductAttributeSet;
use App\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Product Type';
        $this->breadcrumb = [
            'Store' => '',
            'Product type' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = $this->page_title;
        $breadcrumb = $this->breadcrumb;
        $types = ProductType::paginate(15);
        $attribute_Sets =  ProductAttributeSet::all()->pluck('name','id')->toArray();
        return view('store.types.index', compact('page_title', 'breadcrumb', 'types', 'attribute_Sets'));

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
        $input = $request->only(['name', 'description', 'product_attribute_set_id']);
        ProductType::create($input);
        session()->flash('success','Added successfully');
        return redirect()->route('store.types.index');

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
     * @param \Illuminate\Http\Request $request
     * @param ProductType $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductType $type)
    {
        $input = $request->only(['name', 'description', 'product_attribute_set_id']);
        $type->update($input);
        session()->flash('success','Updated successfully');
        return redirect()->route('store.types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductType $productType
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ProductType $type)
    {
        //TODO: dont delete system types
        $type->delete();
        session()->flash('success','Deleted successfully');
        return redirect()->route('store.types.index');

    }
}
