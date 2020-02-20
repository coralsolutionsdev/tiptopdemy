<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use Sluggable;

    protected $fillable = [
        'name', 'slug', 'description', 'parent_id',
        'position', 'meta_title', 'meta_keywords', 'meta_description',
        'type', 'status', 'images'
    ];
    protected $casts = [
        'images' => 'array'
    ];
    const TYPE_POST = 1;
    const TYPE_PAGE = 2;
    const TYPE_PRODUCT = 3;
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

}
