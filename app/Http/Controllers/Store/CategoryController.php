<?php

namespace App\Http\Controllers\Store;

use App\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Store Categories';
        $this->breadcrumb = [
            'Store' => '',
            'categories' => '',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $page_title = __('main.Store Categories');
        $breadcrumb = $this->breadcrumb;
        $categoriesCollection =  $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id',0)->get();
        return view('store.categories.index', compact('categoriesCollection', 'page_title', 'breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title =  __('main.Store Categories') . ' - ' .__('main.Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        $categories = ['0' => __('main.Please Select Category')] + Category::getRootCategories(Category::TYPE_PRODUCT)->pluck('name', 'id')->toArray();
        return view('store.categories.create', compact('page_title', 'breadcrumb', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only([ 'name', 'description', 'parent_id',
            'position', 'meta_title', 'meta_keywords', 'meta_description',
            'type', 'status', 'images', 'show_on_menu']);
        $input['type'] = Category::TYPE_PRODUCT;
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        Category::create($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.categories.index');
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
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $page_title =  __('main.Store Categories') . ' - ' .__('main.Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        $categories = ['0' => 'No parent'] + Category::getRootCategories(Category::TYPE_PRODUCT)->pluck('name', 'id')->toArray();
        return view('store.categories.create', compact('page_title', 'breadcrumb', 'categories', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->only([ 'name', 'description', 'parent_id',
            'position', 'meta_title', 'meta_keywords', 'meta_description',
            'type', 'status', 'images', 'show_on_menu']);
        $input['type'] = Category::TYPE_PRODUCT;
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        $category->update($input);
        session()->flash('success',trans('main._update_msg'));
        return redirect()->route('store.categories.index');
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
        StoreCategory::where('id',$id)->delete();
        session()->flash('success',trans('main._delete_msg'));
        return redirect()->route('categories.index');
    }
}
