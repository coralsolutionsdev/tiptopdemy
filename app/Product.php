<?php

namespace App;

use App\Modules\ColorPattern\ColorPattern;
use App\Modules\ColorPattern\HasColorPattern;
use App\Modules\Course\Lesson;
use App\Modules\Group\HasGroup;
use Bnb\Laravel\Attachments\HasAttachment;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class Product extends Model implements ReactableContract
{

    use Sluggable;
    use HasTags;
    use HasAttachment;
    use HasGroup;
    use HasColorPattern;
    use Reactable;


    protected $fillable = [
        'name', 'slug', 'description', 'manage_stock',
        'quantity', 'currency', 'price', 'retail_price',
        'special_price', 'special_price_from', 'special_price_to', 'status',
        'qr_path', 'position', 'meta_title', 'meta_keywords',
        'meta_description', 'images', 'product_type_id', 'sku',
        'user_id',
        'country_id',
        'directorate_id',
        'scope_id',
        'field_id',
        'field_option_id',
        'level',
        'color_pattern_id',
        'creator_id',
        'editor_id',
    ];

    const STATUS_AVAILABLE = 1;
    const STATUS_OUT_OF_STOCK = 2;
    const STATUS_DISABLED = 3;
    const STATUS_AVAILABLE_FOR_INSTITUTIONS = 4;
    const STATUS_ARRAY = [
        self::STATUS_AVAILABLE_FOR_INSTITUTIONS     => 'Available for Institutions',
        self::STATUS_AVAILABLE    => 'Available for All',
        self::STATUS_OUT_OF_STOCK => 'Out of Stock',
        self::STATUS_DISABLED     => 'Hidden',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function getStatus(){
        return self::STATUS_ARRAY[$this->status];
    }
    /**
     * Get all of the associated product attributes
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllProductAttr()
    {
        if($type = $this->type) {
            if ($product_attribute_set = $type->attributeSet) {
                return ProductAttribute::where(['product_attribute_set_id' => $product_attribute_set->id])->get()->sortBy('position');
            }
        }
        return collect();
    }
    /**
     * Get the attribute value of the given attribute name
     * @param $name
     * @return null
     */
    public function getProductAttrValue($name)
    {
        if($type = $this->type) {
            if ($product_attribute_set = $type->attributeSet) {
                if ($product_attribute = ProductAttribute::where(['product_attribute_set_id' => $product_attribute_set->id, 'name' => $name])->first()) {
                    if ($attributes = $this->attributes()->wherePivot('product_attribute_id', $product_attribute->id)->first()) {
                        if ($pivot = $attributes->pivot) {
                            if (!empty(json_decode($pivot->value))) {
                                return json_decode($pivot->value, true); // Get the saved value
                            }
                            return $pivot->value; // Get the saved value
                        } else {
                            return $product_attribute->default; // Return the default value
                        }
                    } else {
                        return $product_attribute->default; // Return the default value
                    }
                }
            }
        }
        return null;
    }

    /**
     * @param $attrName
     * @param $value
     * @return bool
     */
    public function hasAttributeValue($attrName, $value) {
        $values = $this->getProductAttrValue($attrName);
        if (is_array($values)) {
            foreach ($values as $val) {
                if ($val === $value) {
                    return true;
                }
            }
            return false;
        }
        return $value === $values;
    }
    /**
     * @param $attr_id
     * @param $option_id
     * @return |null
     */
    public function getProductAttrOptionValueById($attr_id, $option_id){
        $attribute = ProductAttribute::find($attr_id);
        if (!empty($attribute)){
            $attr_options = $attribute->options;
            if (!empty($attr_options)){
                $val = $this->getProductAttrValueById($attr_id);
                $option = $attr_options->where('id',$option_id )->first();
                if (is_array($val) && in_array($option->value, $val)){
                    return $option->value;
                }else{
                    if ($option && $option->value == $val){
                        return $option->value;
                    }                }
            }
        }
        return null;
    }
    /**
     * @param $id
     * @return mixed|null
     */
    public function getProductAttrValueById($id)
    {
        if($type = $this->type) {
            if ($product_attribute_set = $type->attributeSet) {
                if ($product_attribute = ProductAttribute::where(['product_attribute_set_id' => $product_attribute_set->id, 'id' => $id])->first()) {
                    if ($attributes = $this->attributes()->wherePivot('product_attribute_id', $product_attribute->id)->first()) {
                        if ($pivot = $attributes->pivot) {
                            if (!empty(json_decode($pivot->value))) {
                                return json_decode($pivot->value, true); // Get the saved value
                            }
                            return $pivot->value; // Get the saved value
                        } else {
                            return $product_attribute->default; // Return the default value
                        }
                    } else {
                        return $product_attribute->default; // Return the default value
                    }
                }
            }
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->attachments()->where('group', 'product_image')->orderBy('position')->get();

    }

    /**
     * get product primary image
     * @return string
     */
    public function getProductPrimaryImage()
    {
        $path =  null;
        $images = $this->getImages();
        if (!empty($images)){
            $image = $images->first();
            if (!empty($image)){
                $path = $image->url;
            }
        }
        return $path;
    }
    /**
     * @return string
     */
    public function getProductAlternativeImage()
    {
        $path =  null;
        $images = $this->getImages();
        if (!empty($images)){
            $image = $images->get(1);
            if (!empty($image)){
                $path = $image->url;
            }
        }
        return $path;
    }
    /**
     * Get the array list of this product tags
     * @return array
     */
    public function getTags()
    {
        $spatie_tags = $this->tagsWithType('product');
        $tags = array();
        foreach($spatie_tags as $tag) {
            $tags[$tag->name] = $tag->name;
        }
        return $tags;
    }
    public function getAttributesWithType($type = null)
    {
        if (!is_null($type)){
            return $this->attributes()->where('type',$type)->get();
        }
        return $this->attributes();
    }
    public function getColorPattern()
    {
        return ColorPattern::find($this->color_pattern_id);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
    /**
     * Relationship method for accessing the pictures
     *
     * @return mixed
     */
    public function images()
    {
        return $this->hasMany('App\ProductImage')->orderBy('position', 'asc');
    }

    /**
     * Relationship method for accessing the type
     *
     * @return mixed
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    /**
     * Many-To-Many Relationship Method for accessing the categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany('App\Modules\Group\Group', 'owner_id')->where('owner_type', $this->getClassName());
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'product_id');
    }

    /**
     * Relationship method for accessing the order items
     *
     * @return mixed
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship method for accessing the orders
     *
     * @return mixed
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }

    /**
     * Relationship method for accessing the invoices
     *
     * @return mixed
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_items');
    }

    /**
     * Relationship method for accessing the product attributes
     *
     * @return mixed
     */
    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_product_attribute')->withPivot('value');
    }

    /**
     * Relationship to get product user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','creator_id');
    }
}
