<?php

namespace App\Http\Controllers\Store;

use App\ProductAttributeSet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductAttributeSetController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Attribute Sets';
        $this->breadcrumb = [
            'Store' => '',
            'Attribute Sets' => '',
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
        $attribute_sets = ProductAttributeSet::latest()->paginate(15);
        return view('store.attribute_sets.index', compact('page_title', 'breadcrumb', 'attribute_sets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        return view('store.attribute_sets.create', compact('page_title','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param ProductAttributeSet $set
     */
    public function store(Request $request, ProductAttributeSet $set)
    {
        $input = $request->only($set->getFillable());
        //Default values
        if (empty($input['position'])) {
            $input['position'] = 0;
        }
        $set = ProductAttributeSet::create($input);
        return redirect()->route('store.sets.edit', $set->id);

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
     * @param ProductAttributeSet $set
     * @return string
     */
    public function edit(ProductAttributeSet $set)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        return view('store.attribute_sets.create', compact('page_title','breadcrumb', 'set'));
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
