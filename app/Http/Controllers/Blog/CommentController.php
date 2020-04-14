<?php

namespace App\Http\Controllers\Blog;

use App\BlogComment;
use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        ];
        return response($item,200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BlogComment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $comment)
    {
        //
        $comment->delete();
        return response('success',200);

    }
}
