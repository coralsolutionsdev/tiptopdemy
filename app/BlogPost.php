<?php

namespace App;

use App\Modules\Comment\Commentable;
use App\Services\FileAssetManagerService;
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
    public function sluggable(): array
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

    /**
     * @param $input
     * @param null $post
     * @return \Illuminate\Http\RedirectResponse|null
     * @throws \Exception
     */
    public static function createOrUpdate($input, $post = null)
    {
        $user = getAuthUser();
        if (empty($user)){
            return redirect()->back();
        }
        $setFirstImageAsCover = false;
        $coverImageId = null;
        $input['user_id'] = $user->id;
        // default status
        $input['status'] = isset($input['status']) && !empty($input['status']) ? self::STATUS_ENABLED : self::STATUS_DISABLED;
        // default allow_comments_status
        $input['allow_comments_status'] = isset($input['allow_comments_status']) && !empty($input['allow_comments_status']) ? self::STATUS_ENABLED : self::STATUS_DISABLED;
        // default comment_status
        $input['default_comment_status'] = isset($input['default_comment_status']) && !empty($input['default_comment_status']) ? self::STATUS_ENABLED : self::STATUS_DISABLED;
        if (!empty($post)){
            //update post images
            $postImagesInputArray = isset($input['images']) && !empty($input['images'])? $input['images'] : array();
            if (!empty($post->images)){
                $postImages = $post->images;
                foreach ($post->images as $key => $image){
                    if (empty($postImagesInputArray) || !array_key_exists($key,$postImagesInputArray)){
                        FileAssetManagerService::ImageDestroy($image);
                        unset($postImages[$key]);
                        if ($image == $post->cover_image){ // if cover image deleted
                            $setFirstImageAsCover = true;
                        }
                    }
                }
                // set default cover image
                if ($setFirstImageAsCover == true && !empty($postImages)){
                    $input['cover_image'] =  $postImages[array_key_first($postImages)];
                }
            }
        }
        if (!isset($input['images'])){
            $input['images'] =  null;
        }

        // upload cover image
        if (isset($input['image'])) {
            // upload and save image
            $image = $input['image'];
            $location =  config('baseapp.post_image_storage_path').'/'.$user->getCompanyId().'/'.$user->id;
            $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
            $input['cover_image'] = $uploaded_image;
            $coverImageId = generateRandomString(4);
            $input['images'][$coverImageId] = $input['cover_image'];
        }else{
            // update selected default_cover
            $input['cover_image'] = null;
            if (!empty($post)){
                if (!empty($input['default_cover'])){
                    if (array_key_exists($input['default_cover'],$postImagesInputArray)){
                        $input['cover_image'] = $postImagesInputArray[$input['default_cover']];
                    }
                }
            }
        }

        if (!empty($post)){
            // update post
            $post->update($input);
        }else{
            // create post
            $post = BlogPost::create($input);
        }

        // update Category
        $categories =!empty($input['categories']) ? $input['categories'] :  array();
        $post->categories()->sync($categories);

        // update tags
        $tags =!empty($input['tags']) ? $input['tags'] :  array();
        $post->syncTagsWithType($tags, 'post');

        // attachments
        if (isset($input['attachments'])){
            $comments = $input['attachments'];
            foreach ($comments as $comment){
                $post->attach($comment);
            }
        }
        return $post;
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
