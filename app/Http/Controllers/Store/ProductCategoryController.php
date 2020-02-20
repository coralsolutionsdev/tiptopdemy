<?php

namespace App\Http\Controllers\Store;

use App\BlogCategory;
use App\Category;
use App\Domain;
use App\ProductAttributeSet;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Products Categories';
        $this->breadcrumb = [
            'Store' => '',
            'Categories' => '',
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
        $categoriesCollection =  $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id',0)->get()->pluck('name','id')->toArray();
        return view('store.categories.index', compact('page_title', 'breadcrumb','categoriesCollection'));

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
        $categories = ['0' => 'No parent'] + Category::getRootProductCategories()->pluck('name', 'id')->toArray();
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
        $input = $request->only([ 'name', 'slug', 'description', 'parent_id',
            'position', 'meta_title', 'meta_keywords', 'meta_description',
            'type', 'status', 'images']);
        $input['type'] = Category::TYPE_PRODUCT;
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        Category::create($input);
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
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        $categories = ['0' => 'No parent'] + Category::getRootProductCategories()->pluck('name', 'id')->toArray();
        return view('store.categories.create', compact('page_title', 'breadcrumb', 'categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->only([ 'name', 'slug', 'description', 'parent_id',
            'position', 'meta_title', 'meta_keywords', 'meta_description',
            'type', 'status', 'images']);
        $input['type'] = Category::TYPE_PRODUCT;
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        if ($category->name != $request->input('name')){
            $slug = SlugService::createSlug(Category::class, 'slug', $request->input('name'), ['unique' => true]);
            $input['slug'] = $slug;
        }
        $category->update($input);
        return redirect()->route('store.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('store.categories.index');

    }
}
