<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    //
    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function comments()
    {
        return $this->hasMany('App\BlogComment','parent_id');
    }

}
