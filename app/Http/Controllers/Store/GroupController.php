<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Group\Group;
use App\Product;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class GroupController extends Controller
{
    protected $breadcrumb;
    protected $page_title;
    protected $modelName;

    public function __construct()
    {
        $this->page_title = 'Store Units';
        $this->modelName = 'Store';
        $this->breadcrumb = [
            'Store' => '',
            'Product' => '',
            'Units' => '',
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
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $page_title =  __('main.Units') . ' - ' .__('main.Create');
        $modelName = $this->modelName;
        $breadcrumb =  Breadcrumbs::render('admin.store.groups.create', $product);
        return view('store.groups.create', compact('page_title', 'breadcrumb', 'product', 'modelName'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Request $request, Product $product)
    {
        $input = $request->all();
        $group = $product->createGroup($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect(route('store.products.edit', $product->slug). "/#lessons");
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
     * @param Product $product
     * @param Group $group
     * @return void
     */
    public function edit(Product $product, Group $group)
    {
        $page_title =  __('main.Units') . ' - ' .__('main.Edit');
        $modelName = $this->modelName;
        $breadcrumb =  Breadcrumbs::render('admin.store.groups.edit', $product, $group);
        return view('store.groups.create', compact('page_title', 'breadcrumb', 'product', 'group', 'modelName'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param Group $group
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, Product $product, Group $group)
    {
        $input = $request->all();
        $input['status'] = $request->status ?? 0;
        $input['editor_id'] = getAuthUser()->id;
        $group->update($input);
        $selectedTab = 'lessons';
        session()->flash('success',__('Updated Successfully'));
        return redirect(route('store.products.edit', $product->slug). "/#lessons");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Group $group
     * @return void
     */
    public function destroy(Product $product, Group $group)
    {
        $group->deleteWithDependencies();
        return redirect(route('store.products.edit', $product->slug). "/#lessons");
    }
}
