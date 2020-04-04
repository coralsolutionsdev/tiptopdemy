<?php

namespace App\Http\Controllers\Blog;

use App\Category;
use App\Institution\InstitutionScope;
use App\Services\FileAssetManagerService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use App\BlogCategory;
use auth;
use Illuminate\Http\Response;
use Image;
use Spatie\Tags\Tag;
use Storage;

class PostController extends Controller
{
    protected $breadcrumb;
    protected $page_title;
    
    public function __construct()
    {
    $this->middleware('auth', ['except' => ['GetIndex','show']]);
    $this->page_title = 'Blog Posts';
    $this->breadcrumb = [
        'blog' => '',
        'posts' => '',
    ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $count = BlogPost::where('id','>','1')->count();
        $posts = BlogPost::latest()->paginate(15);
//        $categories =  BlogCategory::all();
//        if ($categories->count() < 1){
//            session()->flash('warning', 'You haven\'t created any blog categories. Please create new one before proceed. ');
//        }
        return view('blog.posts.index', compact('page_title', 'breadcrumb','posts','count'));
    }
     public function GetIndex(Request $request)
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $blog_search =  null;
        if(!empty($request->blog_search)){
            $blog_search =  $request->blog_search;
            $posts = BlogPost::latest()->where('status','1')->whereRaw("(title like '%$blog_search%' or content like '%$blog_search%')")->paginate(10);
        }else{
            $posts = BlogPost::latest()->where('status','1')->paginate(10);
        }
        $postscount = BlogPost::latest()->where('status','1')->count();
        $count = BlogPost::where('id','>','1')->count();
        $all_posts = BlogPost::latest()->where('status','1')->paginate(5);
        return view('blog.frontend.index', compact('page_title', 'breadcrumb','posts','count','categories','postscount','all_posts','blog_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
            'Create' => ''
        ];
        $tree_categories = Category::where('type', Category::TYPE_POST)->where('parent_id', 0)->get();
        $categories = Category::getRootCategories(Category::TYPE_POST)->pluck('name', 'id')->toArray();
        return view('blog.posts.create', compact('page_title','breadcrumb','categories', 'tree_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth()->user()->id;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        $input['status'] = $status;
        // upload save image
        if ($request->hasFile('image')) {
            // upload and save image
            $image = $request->file('image');
            $location =  config('baseapp.post_image_storage_path');
            $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
            $input['image'] = $uploaded_image;
        }
        $post = BlogPost::create($input);
        // update Category
        $categories = $request->input('categories', array());
        $post->categories()->sync($categories);

        // update tags
        $tags = $request->input('tags', array());
        $post->syncTagsWithType($tags, 'post');


        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('posts.index');


//        if ($request->isMethod('post')){
//             if ($request->input('slug') != ''){
//                 $this->validate($request, [
//                 'slug'         => 'alpha_dash|min:0|max:255|unique:blog_posts,slug',
//                ]);
//            }
//                $this->validate($request, [
//                 'title'        => 'required',
//                 'category_id'  => 'required|integer',
//                 'content'      => 'required',
//                 'image'        => 'sometimes|image',
//                ]);
//                $input =  $request->only(
//                    'title',
//                    'category_id',
//                    'slug',
//                    'image',
//                    'content',
//                    'status'
//                );
//
//                $input['user_id'] = Auth()->user()->id;
//                if(!empty($input['status'])){
//                    $status = 1;
//                }else{
//                    $status = 0;
//                }
//
//            }
    }

    /**
     * Display the specified resource.
     *
     * @param BlogPost $post
     * @return Response
     */
    public function show(BlogPost $post)
    {
        $categories = Category::getRootCategories(Category::TYPE_POST);
        $posts = BlogPost::latest()->paginate(5);
        $page_title =  $post->title;
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $post->title => ''
            ];
        return view('blog.frontend.show', compact('page_title', 'breadcrumb', 'post' , 'categories', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogPost $post
     * @return Response
     */
    public function edit(BlogPost $post)
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        $tree_categories = Category::where('type', Category::TYPE_POST)->where('parent_id', 0)->get();
        $categories = Category::getRootCategories(Category::TYPE_POST)->pluck('name', 'id')->toArray();
        $selectedCategories = $post->categories()->pluck('id')->toArray();
        $tags = Tag::getWithType('post')->pluck('name', 'name');
        $selectedTags = $post->getTags();
        return view('blog.posts.create', compact('page_title','breadcrumb','post','categories', 'tree_categories','selectedCategories', 'tags', 'selectedTags'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $post = BlogPost::find($id);
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        $input['status'] = $status;
        if ($request->hasFile('image')) {
            // upload and save image
            $image = $request->file('image');
            $location =  config('baseapp.post_image_storage_path');
            $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
            $input['image'] = $uploaded_image;
            // Delete old image
            FileAssetManagerService::ImageDestroy($post->image);
        }
        // update slug
        if ($post->title != $request->input('title')){
            $slug = SlugService::createSlug(BlogPost::class, 'slug', $request->input('title'), ['unique' => true]);
            $post->slug = $slug;
        }
        $post->update($input);

        // update Category
        $categories = $request->input('categories', array());
        $post->categories()->sync($categories);

        // update tags
        $tags = $request->input('tags', array());
        $post->syncTagsWithType($tags, 'post');

        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('posts.index');

//        if ($request->isMethod('PUT')){
//
//            if ($request->input('slug') != $post->slug){
//                $this->validate($request, [
//                    'slug'         => 'alpha_dash|min:0|max:255|unique:blog_posts,slug',
//                ]);
//
//            }
//            $this->validate($request, [
//                'title'        => 'required',
//                'category_id'  => 'required|integer',
//                'content'         => 'required',
//                'image'        => 'sometimes|image',
//            ]);
//            $input =  $request->only(
//                'title',
//                'category_id',
//                'slug',
//                'image',
//                'content',
//                'status'
//            );
//            $input['user_id'] = Auth()->user()->id;
//            if(!empty($input['status'])){
//                $status = 1;
//            }else{
//                $status = 0;
//            }
//            $input['status'] = $status;
//
//            if ($request->hasFile('image')) {
//                // upload and save image
//                $image = $request->file('image');
//                $location =  config('baseapp.post_image_storage_path');
//                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
//                $input['image'] = $uploaded_image;
//                // Delete old image
//                FileAssetManagerService::ImageDestroy($post->image);
//            }
//
//            $post->update($input);
//            session()->flash('success', trans('main._success_msg'));
//            return redirect()->route('posts.index');
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
        $post = BlogPost::find($id);
        FileAssetManagerService::ImageDestroy($post->image);
        $post->delete();
        session()->flash('success',__('Successfully deleted'));
        return redirect()->route('posts.index');
    }


    
}
