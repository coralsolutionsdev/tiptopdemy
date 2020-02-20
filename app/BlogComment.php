<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    //
    protected $fillable = ['post_id', 'user_id', 'parent', 'content', 'likes', 'dislikes'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

}
