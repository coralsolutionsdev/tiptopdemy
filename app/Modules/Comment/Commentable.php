<?php


namespace App\Modules\Comment;


trait Commentable
{
    public function getClassName()
    {
        return __CLASS__;
    }

    public function addComment()
    {
        return 'added';
    }
    public function getCommentsWithDetails()
    {
        return $this->comments->map(function ($comment){
            $comment = $comment->addDetails();
            $comment->sub_comments = $comment->getSubComments();
            return $comment->only([
                'id',
                'comment',
                'likes',
                'commenter_user_id',
                'commenter_name',
                'commenter_profile_pic',
                'commenter_gender',
                'creation_date',
                'is_liked',
                'parent_id',
                'sub_comments',
            ]);
        });
    }
    public function getSubComments(){
        return $this->children->map(function ($comment){
            $comment = $comment->addDetails();
            $comment->replayMode = false;
            return $comment->only([
                'id',
                'comment',
                'comment',
                'likes',
                'commenter_user_id',
                'commenter_name',
                'commenter_profile_pic',
                'commenter_gender',
                'creation_date',
                'is_liked',
                'parent_id',
                'replayMode',
            ]);
        });
    }
    public function getCommentsTree(){
        return $this->getCommentsWithDetails()->where('parent_id', 0);
    }
    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */

    public function user()
    {
        return $this->belongsTo('App\User','commenter_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Modules\Comment\Comment','commentable_id')->where('commentable_type', $this->getClassName())->orderBy('created_at');
    }
    public function children()
    {
        return $this->hasMany('App\Modules\Comment\Comment','parent_id')->where('commentable_type', $this->commentable_type);
    }
}