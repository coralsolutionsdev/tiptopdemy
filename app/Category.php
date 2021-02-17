<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Category extends Model
{

    use Sluggable;

    protected $fillable = [
        'name', 'slug', 'description', 'parent_id',
        'position', 'meta_title', 'meta_keywords', 'meta_description',
        'type', 'status', 'images','show_on_menu'
    ];
    protected $casts = [
        'images' => 'array'
    ];
    const TYPE_POST = 1;
    const TYPE_PAGE = 2;
    const TYPE_PRODUCT = 3;
    const TYPE_FORM = 4;
    const TYPE_FORM_TEMPLATE = 5;
    const TYPES_ARRAY = [
        self::TYPE_POST => 'Post',
        self::TYPE_PAGE => 'Page',
        self::TYPE_PRODUCT => 'Product',
    ];

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
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
     * Get all categories of type product, this usually is use for backend purpose including multiple roots
     * @param null $rootId
     * @return mixed
     */
    public static function getRootProductCategories($rootId = null)
    {
        $categories =  null;
        if (!is_null($rootId)){
            $categories = self::where('type', self::TYPE_PRODUCT)
                ->orderBy('position', 'ASC')
                ->orderBy('name', 'ASC')->get()->filter(function ($category) use($rootId){
                    if ($category->isCategoryBelongsToRoot($rootId)){
                        return true;
                    }
                });
        } else {
            $categories = self::where('type', self::TYPE_PRODUCT)
                ->orderBy('position', 'ASC')
                ->orderBy('name', 'ASC')->get();
        }

        return $categories;
    }

    /**
     * Get all categories of type product, this usually is use for backend purpose including multiple roots
     * @param null $type
     * @param null $rootId
     * @return mixed
     */
    public static function getRootCategories($type =  null, $rootId = null)
    {
        $categories =  null;
        if (is_null($type)){
            $type = self::TYPE_POST;
        }
        if (!is_null($rootId)){
            $categories = self::where('type', $type)
                ->orderBy('position', 'ASC')
                ->orderBy('name', 'ASC')->get()->filter(function ($category) use($rootId){
                    if ($category->isCategoryBelongsToRoot($rootId)){
                        return true;
                    }
                });
        } else {
            $categories = self::where('type', $type)
                ->orderBy('position', 'ASC')
                ->orderBy('name', 'ASC')->get();
        }

        return $categories;
    }
    /**
     * check if the category belongs to the root id
     * @param $rootId
     * @return bool
     */
    public function isCategoryBelongsToRoot($rootId)
    {
        $result = false;
        $parent_cat = $this->parent;
        if ($this->id == $rootId){
            $result =  true;
        }elseif (!empty($parent_cat) && $parent_cat->id == $rootId){
            $result =  true;
        }elseif(!empty($parent_cat->parent) && $parent_cat->isCategoryBelongsToRoot($rootId)){
            $result =  true;
        }
        return $result;
    }

    /**
     * return only enabled items
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|BelongsToMany[]|Collection|mixed
     */
    function getAvailableItems()
    {
        switch($this->type) {
            case self::TYPE_POST:
                return  $this->items()->where('status', BlogPost::STATUS_ENABLED)->get();
                break;
            case self::TYPE_PAGE:
//              return $this->belongsToMany('App\Page');
                return collect();
                break;
            case self::TYPE_PRODUCT:
                return  $this->items->filter(function ($item){
                if ($item->status == Product::STATUS_AVAILABLE || $item->status == Product::STATUS_AVAILABLE_FOR_INSTITUTIONS){
                    return true;
                }
                return false;
            });
                break;
        }

    }
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * One-To-One Relationship Method for accessing the Category->parent
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }

    /**
     * One-To-Many Relationship Method for accessing the Category children
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')->orderBy('name', 'asc');
    }

    /**
     * @return BelongsToMany|Collection
     */
    public function items()
    {
        switch($this->type) {
            case self::TYPE_POST:
                return $this->belongsToMany('App\BlogPost', 'category_blog_post');
                break;
            case self::TYPE_PAGE:
//              return $this->belongsToMany('App\Page');
                return collect();
                break;
            case self::TYPE_PRODUCT:
                return $this->belongsToMany('App\Product');
                break;
            case self::TYPE_FORM_TEMPLATE:
                return $this->belongsToMany('App\Modules\Form\Form');
                break;
        }
    }

}
