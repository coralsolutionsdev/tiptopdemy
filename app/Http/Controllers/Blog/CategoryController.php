<?php

namespace App\Http\Controllers\Blog;

use App\Category;
use App\GalleryAlbum;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use App\BlogCategory;
use Auth;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Image;
use Storage;

class CategoryController extends Controller
{
    protected $modelName;
    protected $page_title;
    protected $breadcrumb;

    public function __construct()
    {
        $this->page_title = 'Blog Categories';
        $this->modelName = 'Blog';
        $this->breadcrumb = [
            'blog' => '',
            'categories' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title = __('main.Blog Categories');
        $breadcrumb = $this->breadcrumb;
        $categoriesCollection =  $tree_categories = Category::where('type', Category::TYPE_POST)->where('parent_id',0)->get();
        return view('blog.categories.index', compact('page_title','breadcrumb','categoriesCollection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title =  __('main.Blog Categories') . ' - ' .__('main.Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        $categories = ['0' => __('main.Please Select Category')] + Category::getRootCategories(Category::TYPE_POST)->pluck('name', 'id')->toArray();
        return view('blog.categories.create', compact('page_title', 'breadcrumb', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->only([ 'name', 'description', 'parent_id',
            'position', 'meta_title', 'meta_keywords', 'meta_description',
            'type', 'status', 'images', 'show_on_menu']);
        $input['type'] = Category::TYPE_POST;
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        Category::create($input);
        session()->flash('success',trans('main._success_msg'));
        return redirect()->route('blog.categories.index');
    }

    /**
     * Display the specified resource.
     * @param Category $category
     * @return Factory|View
     */
    public function show(Category $category)
    {
        $page_title =  $category->name;
        $blog_search =  null;
        $search_key =  null;
        $modelName = $this->modelName;
        $breadcrumb =  Breadcrumbs::render('blog.category', $category);
        $posts = $category->items()->paginate(5);
        return view('blog.frontend.index', compact('modelName', 'page_title', 'breadcrumb','posts','count','categories','postscount','all_posts','blog_search', 'search_key'));
    }

    public function filter(){
        dd('e');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        $page_title =  __('main.Blog Categories') . ' - ' .__('main.Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        $categories = ['0' => 'No parent'] + Category::getRootCategories(Category::TYPE_POST)->pluck('name', 'id')->toArray();
        return view('blog.categories.create', compact('page_title', 'breadcrumb', 'categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->only([ 'name', 'description', 'parent_id',
            'position', 'meta_title', 'meta_keywords', 'meta_description',
            'type', 'status', 'images', 'show_on_menu']);
        $input['type'] = Category::TYPE_POST;
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        $category->update($input);
        session()->flash('success',trans('main._success_msg'));
        return redirect()->route('blog.categories.index');

//         if ($request->isMethod('PUT')){
//
//            $category = BlogCategory::find($id);
//
//            if ($request->input('title') != $category->title)
//            {
//                $this->validate($request, [
//                 'title' => 'required|unique:blog_categories,title',
//                ]);
//
//            }   else{
//                $this->validate($request, [
//                 'title' => 'required',
//                ]);
//                     }
//
//                $category = BlogCategory::find($id);
//                 if ($category->title != $request->input('title')){
//                     $slug = SlugService::createSlug(BlogCategory::class, 'slug', $request->input('title'), ['unique' => true]);
//                     $category->slug = $slug;
//                 }
//                $category->title = $request->input('title');
//                $category->description = $request->input('description');
//                $category->save();
//                session()->flash('success',trans('main._update_msg'));
//                return redirect()->route('blog.categories.index');
//            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        $deleted_posts = BlogPost::all()->where('category_id', $id);
        foreach($deleted_posts as $post)
        {

               if (!empty ( $post->image )) {
                    $oldImage = $post->image;
                    Storage::delete('post_images/'. $oldImage);
               }
            
            $post->delete();
        }
        
        $category = BlogCategory::find($id);
        $category->delete();

        session()->flash('success', trans('main._delete_msg'));
        return redirect()->route('categories.index');
    }
}
