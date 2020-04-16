<?php

namespace App\Http\Controllers\Blog;

use App\BlogComment;
use App\Category;
use App\Institution\InstitutionScope;
use App\Page;
use App\Services\FileAssetManagerService;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use App\BlogCategory;
use auth;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Image;
use Spatie\Tags\Tag;
use Storage;

class PostController extends Controller
{
    protected $breadcrumb;
    protected $page_title;
    
    public function __construct()
    {
    $this->middleware('auth', ['except' => ['GetIndex','show', 'getComments']]);
    $this->page_title = 'Blog Posts';
    $this->breadcrumb = [
        'Blog' => '',
        'Posts' => '',
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
        $search_key =  null;
        if(!empty($request->search_key)){
            $search_key =  $request->search_key;
            $posts = BlogPost::latest()->where('status','1')->whereRaw("(title like '%$search_key%' or content like '%$search_key%')")->paginate(10);
        }else{
            $posts = BlogPost::latest()->where('status','1')->paginate(10);
        }
        return view('blog.frontend.index', compact('page_title', 'breadcrumb','posts','count','categories','search_key'));
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
        $tags = Tag::getWithType('post')->pluck('name', 'name');
        $selectedTags =array();
        return view('blog.posts.create', compact('page_title','breadcrumb','categories', 'tree_categories', 'tags', 'selectedTags'));
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
        //
        if(!empty($input['allow_comments_status'])){
            $allow_comments_status = 1;
        }else{
            $allow_comments_status = 0;
        }
        $input['allow_comments_status'] = $allow_comments_status;
        //
        if(!empty($input['default_comment_status'])){
            $default_comment_status = 1;
        }else{
            $default_comment_status = 0;
        }
        $input['default_comment_status'] = $default_comment_status;
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
        $search_key =  null;
        $page_title =  $post->title;
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $post->title => ''
            ];
        return view('blog.frontend.show', compact('page_title', 'breadcrumb', 'post' , 'categories', 'posts', 'search_key'));
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
        //
        if(!empty($input['allow_comments_status'])){
            $allow_comments_status = 1;
        }else{
            $allow_comments_status = 0;
        }
        $input['allow_comments_status'] = $allow_comments_status;
        //
        if(!empty($input['default_comment_status'])){
            $default_comment_status = 1;
        }else{
            $default_comment_status = 0;
        }
        $input['default_comment_status'] = $default_comment_status;
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogPost $post
     * @return Response
     * @throws \Exception
     */
    public function destroy(BlogPost $post)
    {
        FileAssetManagerService::ImageDestroy($post->image);
        $post->delete();
        session()->flash('success',__('Successfully deleted'));
        return redirect()->route('posts.index');
    }

    /**
     * view post comments
     * @param BlogPost $post
     * @return Factory|Application|View
     */
    public function viewComments(BlogPost $post)
    {
        $page_title =  $this->page_title . ' - ' .__('Comments');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $post->title => '',
                'Comments' => ''
            ];
        $comments =  $post->comments;
        return view('blog.comments.index', compact('page_title', 'breadcrumb', 'comments'));
    }

    /**
     * @param BlogPost $post
     * @return ResponseFactory|Application|Response
     */
    function getComments(BlogPost $post){
        $items =  array();
        if (!empty($post)){
            $comments =  $post->comments->where('parent_id', 0);
            foreach ($comments as $comment){
                $subItems =  array();
                $subComments =  $comment->comments;
                if (!empty($subComments)){
                    foreach ($subComments as $subComment){
                        $subItems[] = [
                            'id' => $subComment->id,
                            'parent_id' => !is_null($subComment->parent_id) ? $subComment->parent_id : 0,
                            'user_profile_pic' => $subComment->user->getProfilePicURL(),
                            'user_name' => $subComment->user->getUserName(),
                            'create_date' => $subComment->created_at->diffForHumans(),
                            'content' => $subComment->content,
                            'likes' =>  $count = $subComment->getReactCount('like'),
                            'user_id' => $subComment->user_id,
                            'status' => $subComment->status,
                            'is_liked' => ($subComment->isReacted('like') == true) ? 1 : 0,
                        ];
                    }
                }
                $items[] = [
                    'id' => $comment->id,
                    'parent_id' => !is_null($comment->parent_id) ? $comment->parent_id : 0,
                    'user_profile_pic' => $comment->user->getProfilePicURL(),
                    'user_name' => $comment->user->getUserName(),
                    'create_date' => $comment->created_at->diffForHumans(),
                    'content' => $comment->content,
                    'likes' =>  $count = $comment->getReactCount('like'),
                    'user_id' => $comment->user_id,
                    'sub_items' => $subItems,
                    'status' => $comment->status,
                    'is_liked' => ($comment->isReacted('like') == true) ? 1 : 0,
                ];
            }
        }
        return response($items,200);
    }

    /**
     * react to post
     * @param BlogPost $post
     * @param $type
     * @return ResponseFactory|Application|Response
     */
    function updateReact(BlogPost $post, $type)
    {
        $count = 0;
        if ($post->isReacted($type)){ // true
            $post->unReactTo($type);
        }else{
            $post->reactTo($type);
        }
        $count = $post->getReactCount($type);
        return response($count,  200);
    }


}
