<?php

namespace App;

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
    use Reactable;


    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'slug',
        'image',
        'content',
        'status',
        'allow_comments_status',
        'default_comment_status',
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

    /**
     * check if user has reacted to item
     * @param $type
     * @return bool
     */
    function isReacted($type)
    {
        $user = getAuthUser();
        if ($user){
            // get reaction type
            if (is_null($type)){
                $type = 'like';
            }
            $reactionType = ReactionType::fromName($type);
            $typeName = $reactionType->getName(); // 'Like'
            if ($user->isNotRegisteredAsLoveReacter()){ // false
                $user->registerAsLoveReacter();
            }
            $reacterFacade = $user->viaLoveReacter();

            $isReacted = $reacterFacade->hasReactedTo($this);
            return $isReacted;
        }
        return false;
    }

    /**
     * assign reaction to item
     * @param $type
     * @param int $weight
     * @return bool
     */
    function reactTo($type,  $weight = 1)
    {
        $user = getAuthUser();
        if ($user){
            // get reaction type
            if (is_null($type)){
                $type = 'like';
            }
            $reactionType = ReactionType::fromName($type);
            $typeName = $reactionType->getName(); // 'Like'

            //model should ne registered ad love reactant
            if ($this->isNotRegisteredAsLoveReactant()){
                $this->registerAsLoveReactant();
            }

            if ($user->isNotRegisteredAsLoveReacter()){ // false
                $user->registerAsLoveReacter();
            }
            $reacterFacade = $user->viaLoveReacter();

            $isNotReacted = $reacterFacade->hasNotReactedTo($this);
            if ($isNotReacted){
                $reacterFacade->reactTo($this, $typeName, $weight);
            }
        }
        return false;
    }

    /**
     * remove reaction from item
     * @param $type
     * @param int $weight
     * @return bool
     */
    function unReactTo($type,  $weight = 1)
    {
        $user = getAuthUser();
        if ($user){
            if ($user){
                // get reaction type
                if (is_null($type)){
                    $type = 'like';
                }
                $reactionType = ReactionType::fromName($type);
                $typeName = $reactionType->getName(); // 'Like'

                //model should ne registered ad love reactant
                if ($this->isNotRegisteredAsLoveReactant()){
                    $this->registerAsLoveReactant();
                }

                if ($user->isNotRegisteredAsLoveReacter()){ // false
                    $user->registerAsLoveReacter();
                }
                $reacterFacade = $user->viaLoveReacter();

                $isReacted = $reacterFacade->hasReactedTo($this);
                if ($isReacted){
                    $reacterFacade->unreactTo($this, $typeName);
                }

            }
        }
        return false;
    }

    /**
     * return reaction count
     * @param null $type
     * @return int
     */
    public function getReactCount($type =  null)
    {
        if ($this->isNotRegisteredAsLoveReactant()){
            $this->registerAsLoveReactant();
        }
        // get reaction type
        if (is_null($type)){
            $type = 'like';
        }
        $reactionType = ReactionType::fromName($type);
        $typeName = $reactionType->getName(); // 'Like'
        $reactantFacade = $this->viaLoveReactant();
        $reactionCounter = $reactantFacade->getReactionCounterOfType($typeName);
        if (!empty($reactionCounter) && !empty($reactionCounter->count)){
            return $reactionCounter->count;

        }
        return 0;
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
