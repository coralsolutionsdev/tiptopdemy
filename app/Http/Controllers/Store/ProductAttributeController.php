<?php

namespace App\Http\Controllers\Store;

use App\ProductAttribute;
use App\ProductAttributeOption;
use App\ProductAttributeSet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductAttributeController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Attributes';
        $this->breadcrumb = [
            'Store' => '',
            'Attributes Sets' => '',
        ];
    }
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
     * @param ProductAttributeSet $set
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ProductAttributeSet $set)
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $set->name => '',
                'Attribute' => '',
                'Create' => ''
            ];
        $types = ProductAttribute::TYPE_ARRAY;
        return view('store.attributes.create', compact('page_title','breadcrumb', 'set', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param ProductAttributeSet $set
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, ProductAttributeSet $set)
    {
        $input = $request->all();
        $input['product_attribute_set_id'] = $set->id;

        if ($input['type'] == ProductAttribute::TYPE_RADIO || $input['type'] == ProductAttribute::TYPE_CHECKBOX || $input['type'] == ProductAttribute::TYPE_COLOR) {
            if (!empty($input['radio_name'])){
                if (count($input['radio_name']) != count($input['radio_position']) ||
                    count($input['radio_name']) != count($input['radio_value'])) {
                    session()->flash('success', __('There was a problem with the additional data. Please make sure you fill all required fields'));
                    return redirect()->back()->withInput();
                }
            }

        }
        $attribute = ProductAttribute::create($input);

        if (!empty($input['radio_name'])){
            if ($input['type'] == ProductAttribute::TYPE_RADIO || $input['type'] == ProductAttribute::TYPE_CHECKBOX || $input['type'] == ProductAttribute::TYPE_COLOR) {
                if (empty($input['radio_default'])) {
                    $input['radio_default'] = -1;
                }
                for ($i = 0; $i < count($input['radio_name']); $i++) {
                    ProductAttributeOption::create([
                        'name' => $input['radio_name'][$i],
                        'value' => !empty($input['radio_value'][$i]) ? $input['radio_value'][$i] : $input['radio_name'][$i],
                        'position' => $input['radio_position'][$i],
                        'is_default' => $input['radio_default'] == $i,
                        'product_attribute_id' => $attribute->id
                    ]);
                }
            }
        }

        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.sets.edit', $set->slug);
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
     * @param ProductAttributeSet $set
     * @param ProductAttribute $attribute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ProductAttributeSet $set, ProductAttribute $attribute)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $set->name => '',
                'Attribute' => '',
                'Edit' => ''
            ];
        $types = ProductAttribute::TYPE_ARRAY;
        return view('store.attributes.create', compact('page_title','breadcrumb', 'set', 'types', 'attribute'));

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param ProductAttributeSet $set
     * @param ProductAttribute $attribute
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, ProductAttributeSet $set, ProductAttribute $attribute)
    {
        $input = $request->all();
        $options =  $attribute->options;
        $removed_options =  isset($input['removed-options']) ? $input['removed-options'] : array();
        if ($input['type'] == ProductAttribute::TYPE_RADIO || $input['type'] == ProductAttribute::TYPE_CHECKBOX || $input['type'] == ProductAttribute::TYPE_COLOR) {
            if (!empty($input['radio_name'])){
                if (count($input['radio_name']) != count($input['radio_position']) ||
                    count($input['radio_name']) != count($input['radio_value'])) {
                    session()->flash('success', __('There was a problem with the additional data. Please make sure you fill all required fields'));
                    return redirect("admin/products/sets/$set->id/attributes/$attribute->id/edit")->withInput();
                } else {
                    if ($input['type'] == ProductAttribute::TYPE_RADIO || $input['type'] == ProductAttribute::TYPE_CHECKBOX || $input['type'] == ProductAttribute::TYPE_COLOR) {
                        if (!isset($input['radio_default'])) {
                            $input['radio_default'] = -1;
                        }
                        for ($i = 0; $i < count($input['radio_name']); $i++) {
                            if (!empty($input['radio_id']) && is_array($input['radio_id'])) {
                                if (!empty($input['radio_id'][$i])) {
                                    if ($option = ProductAttributeOption::find($input['radio_id'][$i])) {
                                        $option->fill([
                                            'name' => $input['radio_name'][$i],
                                            'value' => !empty($input['radio_value'][$i]) ? $input['radio_value'][$i] : $input['radio_name'][$i],
                                            'position' => $input['radio_position'][$i],
                                            'is_default' => $input['radio_default'] == $i
                                        ]);
                                        $option->save();
                                        continue;
                                    }
                                }
                            }
                            ProductAttributeOption::create([
                                'name' => $input['radio_name'][$i],
                                'value' => !empty($input['radio_value'][$i]) ? $input['radio_value'][$i] : $input['radio_name'][$i],
                                'position' => $input['radio_position'][$i],
                                'is_default' => $input['radio_default'] == $i,
                                'product_attribute_id' => $attribute->id
                            ]);


                        }
                    }
                }
            }
            // delete removed options
            foreach ($options as $item) {
                if (in_array($item->id, $removed_options)){
                    $item->delete();
                }
            }

        }
        $attribute->fill($input)->save();
        session()->flash('success', __('updated successfully'));
        return redirect()->route('store.sets.edit', $set->slug);
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductAttributeSet $set, ProductAttribute $attribute)
    {
        //
    }
}
