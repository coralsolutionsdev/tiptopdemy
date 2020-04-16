<?php

namespace App\Http\Controllers\Blog;

use App\BlogComment;
use App\BlogPost;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $input['parent_id'] = isset($input['parent_id']) ? $input['parent_id'] : 0;
        $comment = BlogComment::create($input);
        $item = [
            'id' => $comment->id,
            'parent_id' => !is_null($comment->parent_id) ? $comment->parent_id : 0,
            'user_profile_pic' => $comment->user->getProfilePicURL(),
            'user_name' => $comment->user->getUserName(),
            'create_date' => $comment->created_at->diffForHumans(),
            'content' => $comment->content,
            'likes' => 0,
            'user_id' => $comment->user_id,
            'sub_items' => null,
            'status' => $comment->status,
            'is_liked' => ($comment->isReacted('like') == true) ? 1 : 0,
        ];
        return response($item,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param BlogComment $comment
     * @return void
     */
    public function update(Request $request, BlogComment $comment)
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
     * @param  BlogComment  $comment
     * @return Response
     */
    public function destroy(BlogComment $comment)
    {
        //
        if (!empty($comment)){
            if (!empty($comment->comments)){
                foreach ($comment->comments as $item){
                    $item->delete();
                }
            }
            $comment->delete();
        }
        session()->flash('success', trans('deleted successfully'));
        return redirect()->back();
    }

    /**
     * ajax method to remove comments
     * @param BlogComment $comment
     * @return ResponseFactory|Application|Response
     * @throws \Exception
     */
    function deleteComments(BlogComment $comment)
    {
        $status = 0;
        if (!empty($comment)){
            if (!empty($comment->comments)){
                foreach ($comment->comments as $item){
                    $item->delete();
                }
            }
            $comment->delete();
        }
        return response($status,  200);
    }

    /**
     * react to comment
     * @param BlogComment $comment
     * @param $type
     * @return ResponseFactory|Application|Response
     */
    function updateReact(BlogComment $comment, $type)
    {
        $count = 0;
        if ($comment->isReacted($type)){ // true
            $comment->unReactTo($type);
        }else{
            $comment->reactTo($type);
        }
        $count = $comment->getReactCount($type);
        return response($count,  200);
    }
}
