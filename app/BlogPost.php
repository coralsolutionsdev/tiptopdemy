<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Tags\HasTags;

class BlogPost extends Model
{
    use HasTags;

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
    /**
     * Get the array list of this product tags
     * @return array
     */
    public function getTags()
    {
        $spatie_tags = $this->tagsWithType('post');
        $tags = array();
        foreach($spatie_tags as $tag) {
            $tags[$tag->name] = $tag->name;
        }
        return $tags;
    }

    /*
     |--------------------------------------------------------------------------
     | Relationship Methods
     |--------------------------------------------------------------------------
     */
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
    /**
     * Many-To-Many Relationship Method for accessing the categories
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category','category_blog_post');
    }
}
