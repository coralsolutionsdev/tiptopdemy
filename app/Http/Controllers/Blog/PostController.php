<?php

namespace App\Http\Controllers\Blog;

use App\BlogComment;
use App\Category;
use App\Institution\InstitutionScope;
use App\Page;
use App\Services\FileAssetManagerService;
use App\UniqueId;
use Carbon\Carbon;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
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
use Shivella\Bitly\Facade\Bitly;
use Spatie\Tags\Tag;
use Storage;

class PostController extends Controller
{
    protected $modelName;
    protected $page_title;
    protected $breadcrumb;

    public function __construct()
    {
    $this->middleware('auth', ['except' => [
        'GetIndex',
        'show',
        'getComments',
        'getPost'
    ]]);
    $this->modelName = 'Blog';
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
        $page_title =  trans('main.Blog Posts');
        $breadcrumb =  $this->breadcrumb;
        $posts = BlogPost::latest()->paginate(15);
        return view('blog.posts.index', compact('page_title', 'breadcrumb','posts'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View
     */
     public function GetIndex(Request $request)
    {
        $modelName = $this->modelName;
        $page_title =   __('main.Blog Posts');
        $breadcrumb =  Breadcrumbs::render('blog');
        $search_key =  null;
        if(!empty($request->search_key)){
            $search_key =  $request->search_key;
            $posts = BlogPost::latest()->where('status','1')->whereRaw("(title like '%$search_key%' or content like '%$search_key%')")->paginate(10);
        }else{
            $posts = BlogPost::latest()->where('status','1')->paginate(10);
        }
        return view('blog.frontend.index', compact('page_title', 'breadcrumb','posts','search_key', 'modelName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title =  trans('main.Blog Posts') . ' - ' .__('main.Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
            __('main.Create') => ''
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
        BlogPost::createOrUpdate($input);
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
        $modelName = $this->modelName;
        $page_title =  $post->title;
        $breadcrumb =  Breadcrumbs::render('blog.post.show', $post);
        $attachments = $post->attachments()->get();
        $className = $post->getClassName();
        $userId = getAuthUser() ? getAuthUser()->id : null;
        $userName = getAuthUser() ? getAuthUser()->getUserName() : null;
        $userProfilePic = getAuthUser() ? getAuthUser()->getProfilePicURL() : null;
        $postImage = $post->getMainImage();
        return view('blog.frontend.show', compact('page_title', 'modelName', 'breadcrumb', 'post' , 'categories', 'posts', 'search_key', 'attachments', 'className', 'userId','userName', 'userProfilePic', 'postImage'));
    }
    public function getPost(BlogPost $post)
    {
        $userId = getAuthUser() ? getAuthUser()->id : null;
        $attachments = $post->attachments()->get();
        $attachmentsArray = [];
        if ($attachments){
            foreach ($attachments as $attachment){
                $attachmentsArray[] = [
                    'title' => $attachment->filename,
                    'type' => $attachment->filetype,
                    'download_url' => $attachment->getTemporaryUrl(Carbon::parse(date('y-m-d'))->addDay()),
                ];
            }
        }
//        $url = Bitly::getUrl(route('blog.posts.show',$post->slug)); // http://bit.ly/nHcn3

        $postArray = [
            'title' => $post->title,
            'content' => $post->content,
            'image' => $post->getMainImage(),
            'categories' => $post->categories()->select('name', 'id', 'slug')->get(),
            // 'is_liked' => $post->hasReaction('like'),
            // 'likes' => $post->getReactionCount('like'),
            'post_url' => route('blog.posts.show',$post->slug),
            'user_name' => ucfirst($post->user->name),
            'created_at' => $post->created_at->diffForHumans(),
            'login_user_id' => $userId,
            'attachments' => $attachmentsArray,
        ];
        return response($postArray, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogPost $post
     * @return Response
     */
    public function edit(BlogPost $post)
    {
        $page_title =  trans('main.Blog Posts') . ' - ' .__('main.Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        $tree_categories = Category::where('type', Category::TYPE_POST)->where('parent_id', 0)->get();
        $categories = Category::getRootCategories(Category::TYPE_POST)->pluck('name', 'id')->toArray();
        $selectedCategories = $post->categories()->pluck('id')->toArray();
        $tags = Tag::getWithType('post')->pluck('name', 'name');
        $selectedTags = $post->getTags();
        $attachments = $post->attachments()->get();
        return view('blog.posts.create', compact('page_title','breadcrumb','post','categories', 'tree_categories','selectedCategories', 'tags', 'selectedTags', 'attachments'));

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
        BlogPost::createOrUpdate($input , $post);
        session()->flash('success', trans('main._update_msg'));
        return redirect()->route('posts.index');

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
        // remove reactions
        $reactantFacade = $post->viaLoveReactant();
        $reactions = $reactantFacade->getReactions();
        if (!empty($reactions)){
            foreach ($reactions as $reaction){
                $reaction->delete();
            }
        }
        // remove Comments
        if ($comments = $post->comments){
            foreach ($comments as $comment){
                if ($subComments = $comment->children){
                    foreach ($subComments as $subComment){
                        $subComReactantFacade = $subComment->viaLoveReactant();
                        $reactions = $subComReactantFacade->getReactions();
                        if (!empty($reactions)){
                            foreach ($reactions as $reaction){
                                $reaction->delete();
                            }
                        }
                        $subComment->delete();
                    }
                }
                $comReactantFacade = $comment->viaLoveReactant();
                $reactions = $comReactantFacade->getReactions();
                if (!empty($reactions)){
                    foreach ($reactions as $reaction){
                        $reaction->delete();
                    }
                }
                $comment->delete();
            }
        }
        FileAssetManagerService::ImageDestroy($post->cover_image);
        if (!empty($post->images)){
            foreach ($post->images as $key => $image){
                FileAssetManagerService::ImageDestroy($image);
            }
        }
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
        $page_title =  $post->title . ' - ' .__('main.Comments');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $post->title => '',
                __('main.Comments') => ''
            ];
        $comments =  $post->comments;
        return view('blog.comments.index', compact('page_title', 'breadcrumb', 'comments'));
    }

    /**
     * @param BlogPost $post
     * @return ResponseFactory|Application|Response
     */
    function getComments(BlogPost $post){
        $comments = $post->getCommentsWithDetails();
        return response($comments,200);
    }

    /**
     * react to post
     * @param BlogPost $post
     * @param $type
     * @return ResponseFactory|Application|Response
     */
    function updateReact(BlogPost $post, $type)
    {
        if ($post->hasReaction($type)){ // true
            $post->removeReaction($type);
        }else{
            $post->addReaction($type);
        }
        return response('success',  200);
    }

    /**
     * store image
     * @param Request $request
     */

    function imageUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file;
            $user = getAuthUser();
            $fileName = $file->getClientOriginalName();

            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // same-origin requests won't set an origin. If the origin is set, it must be valid.
                if ($_SERVER['HTTP_ORIGIN'] == url('/')) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    header("HTTP/1.0 403 Origin Denied");
                    return;
                }
            }

            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $fileName)) {
                header("HTTP/1.0 500 Invalid file name.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $image = $file;
            $location =  config('baseapp.post_image_storage_path').'/'.$user->getCompanyId().'/'.$user->id;
            $path = FileAssetManagerService::ImageStore($image,$location);

            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            $attachmentUrl = url('storage/'.$path);
            $item = [
                'path' =>  $path,
                'url' =>  $attachmentUrl,
            ];
            echo json_encode(array('item' => $item));
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.0 500 Server Error");
        }

    }

    /**
     * delete attachment
     * @param BlogPost $post
     * @param $key
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|Response
     * @throws \Exception
     */
    function attachmentDelete(BlogPost $post, $key)
    {
        $attachment = $post->attachment($key);
        if ($attachment){
            $attachment->delete();
        }
        return response($key, 200);
    }

}
