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
            return $comment;
        });
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