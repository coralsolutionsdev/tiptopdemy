<?php

namespace App\Http\Controllers\Blog;

use App\Services\FileAssetManagerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use App\BlogCategory;
use auth;
use Image;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $count = BlogPost::where('id','>','1')->count();
        $posts = BlogPost::latest()->paginate(15);
        $categories =  BlogCategory::all();
        if ($categories->count() < 1){
            session()->flash('warning', 'You haven\'t created any blog categories. Please create new one before proceed. ');
        }
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
        $categories = BlogCategory::all();
        $all_posts = BlogPost::latest()->where('status','1')->paginate(5);
        return view('blog.frontend.index', compact('page_title', 'breadcrumb','posts','count','categories','postscount','all_posts','blog_search'));
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
        $categories = BlogCategory::all()->pluck('title','id')->toArray();
        return view('blog.posts.create', compact('page_title','breadcrumb','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->isMethod('post')){
             if ($request->input('slug') != ''){
                 $this->validate($request, [
                 'slug'         => 'alpha_dash|min:0|max:255|unique:blog_posts,slug',
                ]);
            }
                $this->validate($request, [
                 'title'        => 'required',
                 'category_id'  => 'required|integer',
                 'content'      => 'required',
                 'image'        => 'sometimes|image',
                ]);
                $input =  $request->only(
                    'title',
                    'category_id',
                    'slug',
                    'image',
                    'content',
                    'status'
                );

                $input['user_id'] = Auth()->user()->id;
                if(!empty($input['status'])){
                    $status = 1;
                }else{
                    $status = 0;
                }
                $input['status'] = $status;
                // upload save image
                if ($request->hasFile('image')) {
                    // upload and save image
                    $image = $request->file('image');
                    $location =  config('baseapp.post_image_storage_path');
                    $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                    $input['image'] = $uploaded_image;
                }
                BlogPost::create($input);
                session()->flash('success', trans('main._success_msg'));
                return redirect()->route('posts.index');
            }
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
        $post = BlogPost::find($id);
        $posts = BlogPost::latest()->paginate(5);
        $categories = BlogCategory::all();
        return view('blog.frontend.show', compact('post' , 'categories', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        $post = BlogPost::find($id);
        $categories = BlogCategory::all()->pluck('title','id')->toArray();
        return view('blog.posts.create', compact('page_title','breadcrumb','post','categories'));

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
        $post = BlogPost::find($id);

        if ($request->isMethod('PUT')){

            if ($request->input('slug') != $post->slug){
                $this->validate($request, [
                    'slug'         => 'alpha_dash|min:0|max:255|unique:blog_posts,slug',
                ]);

            }
            $this->validate($request, [
                'title'        => 'required',
                'category_id'  => 'required|integer',
                'content'         => 'required',
                'image'        => 'sometimes|image',
            ]);
            $input =  $request->only(
                'title',
                'category_id',
                'slug',
                'image',
                'content',
                'status'
            );
            $input['user_id'] = Auth()->user()->id;
            if(!empty($input['status'])){
                $status = 1;
            }else{
                $status = 0;
            }
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

            $post->update($input);
            session()->flash('success', trans('main._success_msg'));
            return redirect()->route('posts.index');
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
        $post = BlogPost::find($id);
        FileAssetManagerService::ImageDestroy($post->image);
        $post->delete();
        session()->flash('success',__('Successfully deleted'));
        return redirect()->route('posts.index');
    }

    public function GetSlug($slug){

        $post = BlogPost::where('slug','=',$slug)->first();
        $posts = BlogPost::latest()->paginate(5);
        $categories = BlogCategory::all();
        $page_title =  $post->title;
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $post->title => ''
            ];
        return view('blog.frontend.show', compact('page_title', 'breadcrumb', 'post' , 'categories', 'posts'));

    }

    
}
