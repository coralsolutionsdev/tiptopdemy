<?php

namespace App\Http\Controllers\Comment;

use App\BlogPost;
use App\Events\MyEvent;
use App\Events\SendNotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Store\Products as ProductsResource;
use App\Modules\Comment\Comment;
use App\Notifications\Blog\PostComment;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Comments as CommentsResource;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['id', 'commentable_id', 'commentable_type', 'comment', 'parent_id', 'status', 'recaptcha_token']);
        $user = getAuthUser();
        if ($user){
            // logged users comments
            $input['commenter_id'] = $user->id;
            $input['commenter_type'] = $user->getClassName();
        }else{
            // guests comments
        }
        $input['parent_id'] = !is_null( $input['parent_id']) ?  $input['parent_id'] : 0;
        $comment = Comment::create($input);
        $comment = $comment->addDetails();
        // send notification // TODO: improve this
        if ($user){ // commenter
            $model = $comment['commentable_type'];
            $commentableModel = $model::find($comment['commentable_id']); //  get model eloquent
            if ($commentableModel){
                if ($comment['commentable_type'] == 'App\BlogPost'){ // PostComment notification
                    // TODO: complete notifications
                    $notifiableUser = $commentableModel->user;
//                    if ($notifiableUser){
//                        $notifiableUser->notify(new PostComment($user, $commentableModel));
//                         event(new MyEvent('hello world'));
//                        event(new SendNotificationEvent('Comment added'));
//                    }
                }
            }
        }
        $comment->posted_id = $input['id'];
        return response($comment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modules\Comment\Comment  $comment
     * @return Response
     */
    public function show($id)
    {
        dd('here');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modules\Comment\Comment  $comment
     * @return Response
     */
    public function edit(Comment $comment)
    {
        dd('edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modules\Comment\Comment  $comment
     * @return Response
     */
    public function update(Request $request, Comment $comment)
    {
        $input = $request->only(['status']);
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $comment->status = $status;
        $comment->save();
        session()->flash('success', trans('Updated successfully'));
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modules\Comment\Comment  $comment
     * @return Response
     */
    public function destroy(Comment $comment)
    {
        if (!empty($comment)){
            if (!empty($comment->children)){
                foreach ($comment->children as $item){
                    $item->delete();
                }
            }
            $comment->delete();
        }
        session()->flash('success', trans('deleted successfully'));
        return redirect()->back();
    }

    /**
     * remove comment by ajax request
     * @param Comment $comment
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Exception
     */

    public function getItems(Request $request){
        $input = $request->only(['slug', 'class_name','page']);
        $slug = $input['slug'];
        $modal = $input['class_name'];
        $modalItem = $modal::where('slug', $slug)->first();
        $comments = Comment::where('commentable_id', $modalItem->id)->where('commentable_type', $modalItem->getClassName())->where('parent_id', 0)->orderBy('created_at')->paginate(10);
        $comments->map(function ($comment){
            $comment = $comment->addDetails();
            $comment->sub_comments = $comment->getSubComments();
            $comment->replayMode = false;
            return $comment;
        });
        return CommentsResource::collection($comments);
    }
    public function ajaxDestroy(Comment $comment)
    {
        // remove Comments
        if (!empty($comment)){
            if (!empty($comment->children)){
                foreach ($comment->children as $item){
                    $comReactantFacade = $item->viaLoveReactant();
                    $reactions = $comReactantFacade->getReactions();
                    if (!empty($reactions)){
                        foreach ($reactions as $reaction){
                            $reaction->delete();
                        }
                    }
                    $item->delete();
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
        return response('success', 200);
    }

    /**
     * update comment by ajax request
     * @param Request $request
     * @param Comment $comment
     * @return Application|ResponseFactory|Response
     */
    public function ajaxUpdate(Request $request, Comment $comment)
    {
        $input = $request->only(['comment']);
        if (!empty($comment)){
            $comment->comment = $input['comment'];
            $comment->save();
        }
        return response($input['comment'], 200);
    }

    /**
     * @param Comment $comment
     * @param $type
     * @return Application|ResponseFactory|Response
     */
    function updateReact(Comment $comment, $type)
    {
        if ($comment->hasReaction($type)){ // true
            $comment->removeReaction($type);
        }else{
            $comment->addReaction($type);
        }
        return response('success',  200);
    }
}
