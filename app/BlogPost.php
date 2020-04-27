<?php

namespace App;

use App\Modules\Comment\Commentable;
use Bnb\Laravel\Attachments\HasAttachment;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Tags\HasTags;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class BlogPost extends Model implements ReactableContract

{
    use HasTags;
    use Sluggable;
    use HasAttachment;
    use Reactable;
    use Commentable;


    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'slug',
        'images',
        'cover_image',
        'content',
        'status',
        'allow_comments_status',
        'default_comment_status',
    ];
    protected $casts = [
        'images' => 'array'
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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['title', '']
            ]
        ];
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * get post cover image
     * @return string
     */
    function getMainImage()
    {
        if (!empty($this->cover_image)){
            return asset_image($this->cover_image);

        }elseif (!empty($this->images)){
            foreach ($this->images as $key => $value) {
                return asset_image($value);
                break;
            }
        }
        return asset_image('temp/no-image.png');
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
        return $this->hasMany('App\Modules\Comment\Comment','commentable_id')->where('commentable_type', $this->getClassName());
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
