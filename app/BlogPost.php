<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'slug',
        'image',
        'content',
        'status',
    ];
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    public function getCommentsCount()
    {
        $count = 0;
        if (!empty($this->comments)){
            $count = $this->comments->count();
        }
        return $count;
    }
    // Relationships
    public function category()
    {
    	return $this->belongsTo('App\BlogCategory','category_id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }
    public function comments()
    {
        return $this->hasMany('App\BlogComment','post_id');
    }
}
