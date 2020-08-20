<?php

namespace App\Modules\Category;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Category extends Model
{

    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'company_id',
        'parent_id',
        'position',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'type',
        'status',
        'images',
        'show_on_menu',
        'creator_id',
        'editor_id'

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

    const ROUTE_POST = 'post';
    const ROUTE_PAGE = 'page';
    const ROUTE_PRODUCT = 'product';
    const ROUTE_FORM = 'form';
    const ROUTE_FORM_TEMPLATE = 'form-template';
    const ROUTES_ARRAY = [
        self::ROUTE_POST => self::TYPE_POST,
        self::ROUTE_PAGE => self::TYPE_PAGE,
        self::ROUTE_PRODUCT => self::TYPE_PRODUCT,
        self::ROUTE_FORM => self::TYPE_FORM,
        self::ROUTE_FORM_TEMPLATE => self::TYPE_FORM_TEMPLATE,
    ];

    function getRout(){
        foreach (self::ROUTES_ARRAY as $key => $rout){
            if ($rout == $this->type){
                return $key;
            }
        }
    }

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

    public static function createOrUpdate($input, $category =  null)
    {
        if (empty($input['position'])){
            $input['position'] = 0;
        }
        if (empty($input['status'])){
            $input['status'] = 0;
        }
        $user = getAuthUser();
        $input['editor_id'] = $user->id;
        if (!empty($category)){
            $input['type'] = $category->type;
        }
        if (!empty($category)){
            $category->update($input);
            return  $category;
        }else{
            $input['company_id'] = $user->getCompanyId();
            $input['creator_id'] = $user->id;
            return self::create($input);
        }

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

        }
    }

}
