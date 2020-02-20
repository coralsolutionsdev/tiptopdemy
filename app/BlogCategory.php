<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class BlogCategory extends Model
{
    use Sluggable;

    protected $table = 'blog_categories';
    public function getPostsCount()
    {
        $count = 0;
        if (!empty($this->posts)){
            $count = $this->posts->count();
        }
        return $count;
    }
    public function posts()
    {
    	return $this->hasMany('App\BlogPost','category_id');
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
