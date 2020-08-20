<?php

namespace App\Http\Controllers\Category;

use App\Modules\Category\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Categories';
        $this->breadcrumb = [
            'Category' => '',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $type
     * @return Response
     */
    public function index(){

    }
    public function indexType($type = null)
    {
        $categoryTitle = str_replace('-', ' ', $type);

        $page_title = ucfirst($categoryTitle)." categories";
        $breadcrumb = $this->breadcrumb;

        if (!array_key_exists ($type, Category::ROUTES_ARRAY)){
            abort('404');
        }
        $modelType = $type;
        $categoryType = Category::ROUTES_ARRAY[$type];
        $categoriesCollection =  $tree_categories = Category::where('type', $categoryType)->where('parent_id',0)->get();
        return view('categories.index', compact('page_title','breadcrumb','categoriesCollection', 'categoryType', 'modelType'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null $type
     * @return void
     */
    public function create(){

    }
    public function createType($type = null)
    {
        $categoryTitle = str_replace('-', ' ', $type);
        $page_title = ucfirst($categoryTitle)." categories";
        $breadcrumb = $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $page_title => '',
                'Create' => ''
            ];
        if (!array_key_exists ($type, Category::ROUTES_ARRAY)){
            abort('404');
        }
        $categoryType = Category::ROUTES_ARRAY[$type];
        $categories = ['0' => 'No parent'] + Category::getRootCategories($categoryType)->pluck('name', 'id')->toArray();
        return view('categories.create', compact('page_title', 'breadcrumb', 'categories', 'categoryType'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $category = Category::createOrUpdate($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('category.index.type', $category->getRout());
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
     * @return void
     */
    public function edit(Category $category)
    {
        $categoryTitle = $category->title;
        $page_title = ucfirst($categoryTitle)." categories";
        $breadcrumb = $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $page_title => '',
                'Update' => ''
            ];
        $categoryType = $category->type;
        $categories = ['0' => 'No parent'] + Category::getRootCategories($categoryType)->pluck('name', 'id')->toArray();
        return view('categories.create', compact('page_title', 'breadcrumb', 'categories', 'categoryType', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $category = Category::createOrUpdate($input, $category);
        session()->flash('success', trans('main._update_msg'));
        return redirect()->route('category.index.type', $category->getRout());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return void
     */
    public function destroy(Category $category)
    {
        if ($children = $category->children){
            foreach($children as $item){
                $item->delete();
            }
        }
        $route = $category->getRout();
        $category->delete();
        session()->flash('success', trans('main._delete_msg'));
        return redirect()->route('category.index.type', $route);

    }
}
