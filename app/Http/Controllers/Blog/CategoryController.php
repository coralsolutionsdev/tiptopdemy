<?php

namespace App\Http\Controllers\Blog;

use App\Category;
use App\GalleryAlbum;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use App\BlogCategory;
use Auth;
use Image;
use Storage;

class CategoryController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Blog Categories';
        $this->breadcrumb = [
            'blog' => '',
            'categories' => '',
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
        $categoriesCollection =  $tree_categories = Category::where('type', Category::TYPE_POST)->where('parent_id',0)->get()->pluck('name','id')->toArray();
        return view('blog.categories.index', compact('page_title','breadcrumb','categoriesCollection'));
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
        $categories = ['0' => 'No parent'] + Category::getRootCategories(Category::TYPE_POST)->pluck('name', 'id')->toArray();
        return view('blog.categories.create', compact('page_title', 'breadcrumb', 'categories'));
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
     * @param BlogCategory $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $category = BlogCategory::where('slug',$slug)->first();
        if (empty($category)){
            abort('404');
        }
        $posts = BlogPost::latest()->where('category_id', $category->id)->where('status','1')->paginate(15);
        $categories = BlogCategory::all();
        $page_title =  $category->title;
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $category->title => ''
            ];
        return view('blog.frontend.index', compact('page_title', 'breadcrumb', 'posts','categories'));
    }

    public function filter(){
        dd('e');
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

        $category = BlogCategory::find($id);
        return view('blog.categories.edit')->withCategory($category);
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
         if ($request->isMethod('PUT')){

            $category = BlogCategory::find($id);
            
            if ($request->input('title') != $category->title)
            {
                $this->validate($request, [
                 'title' => 'required|unique:blog_categories,title',
                ]);

            }   else{ 
                $this->validate($request, [
                 'title' => 'required',
                ]);
                     }

                $category = BlogCategory::find($id);
                 if ($category->title != $request->input('title')){
                     $slug = SlugService::createSlug(BlogCategory::class, 'slug', $request->input('title'), ['unique' => true]);
                     $category->slug = $slug;
                 }
                $category->title = $request->input('title');
                $category->description = $request->input('description');
                $category->save();
                session()->flash('success',trans('main._update_msg'));
                return redirect()->route('blog.categories.index');
            }
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
