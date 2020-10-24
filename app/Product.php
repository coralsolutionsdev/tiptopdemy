<?php

namespace App;

use App\Modules\ColorPattern\ColorPattern;
use App\Modules\ColorPattern\HasColorPattern;
use App\Modules\Course\Lesson;
use App\Modules\Group\HasGroup;
use App\Modules\Media\Media;
use App\Modules\Store\Invoice;
use App\Modules\Store\Order;
use App\Modules\Store\OrderItem;
use App\Services\MediaManagerService;
use Bnb\Laravel\Attachments\HasAttachment;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Tags\HasTags;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\File;

class Product extends Model implements ReactableContract, HasMedia
{
    use Sluggable;
    use HasTags;
    use HasAttachment;
    use HasGroup;
    use HasColorPattern;
    use Reactable;
    use HasMediaTrait;


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

    const TYPE_COURSES = 1;


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
        $path =  asset_image('assets/no-image.png');
        $images = $this->getMedia(Media::getGroup(Media::TYPE_PRODUCT_IMAGE));
        if (!empty($images)){
            $image = $images->first();
            if (!empty($image)){
                $path = $image->getFullUrl('card');
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
        $images = $this->getMedia(Media::getGroup(Media::TYPE_PRODUCT_IMAGE));
        if (!empty($images)){
            $image = $images->get(1);
            if (!empty($image)){
                $path = $image->getFullUrl('card');
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

    /**
     * return color pattern
     * @return mixed
     */
    public function getColorPattern()
    {
        return ColorPattern::find($this->color_pattern_id);
    }

    /**
     * Check if product is already added in cart
     * @return bool
     */

    public function isInCart()
    {
        $result = false;
        foreach (Cart::content() as $item){
            if ($item->id == $this->id){
                $result = true;
                break;
            }
        }
        return $result;

    }

    /**
     * Check if Auth user has purshased the product
     * @return false
     */
    public function hasPurchased()
    {
        $user = getAuthUser();
        if (is_null($user)){
            return false;
        }
       return $user->products->where('id', $this->id)->first();
    }

    /**
     * Register media library conversation types
     * @param \Spatie\MediaLibrary\Models\Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->sharpen(10);
        $this->addMediaConversion('card')
            ->width(500)
            ->sharpen(10);
    }

    /**
     * register media allowed extensions
     */
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(Media::getGroup(Media::TYPE_PRODUCT_IMAGE))
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);

    }

    /**
     * create or update item
     * @param $input
     * @param null $product
     * @return RedirectResponse|null
     */
    public static function createOrUpdate($input, $product = null)
    {
        $user = getAuthUser();
        if (empty($user)){
            abort(500);
        }
        if (!empty($input['sku'])) {
            if (Product::where('sku', $input['sku'])->where('id', '<>', $product->id)->count()) {
                session()->flash('danger', 'This SKU is already in use! Please use another SKU instead.');
                return back()->withInput();
            }
        }
        if (empty($input['manage_stock'])) {
            $input['manage_stock'] = 0;
        }
        $input['editor_id'] = $user->id;
        // update slug
        if (!is_null($product)){
            if ($product->name != $input['name']){
                $slug = SlugService::createSlug(Product::class, 'slug', $input['name'], ['unique' => true]);
                $input['slug']= $slug;
            }
            $product->update($input);

            // update Attribute
            $attributes = $product->getAllProductAttr();
            $attribute_values = [];
            foreach ($attributes as $attribute) {
                if (isset($input[$attribute->id]) && $value = $input[$attribute->id]) {
                    $attribute_values[$attribute->id] = ['value' => is_array($value) ? json_encode($value) : $value];
                }
            }
            $product->attributes()->sync($attribute_values);
            //TODO: update cache values
            //$product->updateAttributesCache();
        }else{
            $input['creator_id'] = $user->id;
            $product = self::create($input);
        }

        // update Category
        $categories = isset($input['categories']) ? $input['categories'] :  array();
        $product->categories()->sync($categories);

        // media update //
        $mediaType = Media::TYPE_PRODUCT_IMAGE;
        $productMedia = $product->getMedia(Media::getGroup($mediaType));
        // removed media items
        $mediaRemovedItems = isset($input['media_removed_ids']) && !empty($input['media_removed_ids']) ? $input['media_removed_ids'] :  array();
        if (!empty($mediaRemovedItems)){
            foreach ($mediaRemovedItems as $mediaRemovedItemId){
                $removedProductMedia = $productMedia->where('id', $mediaRemovedItemId)->first();
                if (!empty($removedProductMedia)){
                    $removedProductMedia->delete();
                }
            }
        }
        // media upload
        if (isset($input['media_position'])){
            $mediaPosition = $input['media_position'];
            if (!empty($mediaPosition)){
                foreach ($mediaPosition as $position => $value){
                    if (isset($input['media_id'][$position]) && !empty($input['media_id'][$position])){
                        $mediaItem = $productMedia->where('id', $input['media_id'][$position])->first();
                        if (!empty($mediaItem)){
                            // update position
                            $mediaItem->order_column = $position;
                            $mediaItem->save();

                        }else { // add new item
                            $image = $input['media_files'][$input['media_new_file_order'][$position]];
                            $newMediaItem = MediaManagerService::store($product, $mediaType, $image);
                            if ($newMediaItem){
                                $newMediaItem->order_column = $position;
                                $newMediaItem->save();
                            }
                        }
                    }
                }
            }
        }else{ // no product images
            $product->clearMediaCollection(Media::getGroup($mediaType));
        }

        // update tags
        $tags = isset($input['tags']) ? $input['tags'] : array();
        $product->syncTagsWithType($tags, 'product');

        return $product;
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
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * @return HasMany
     */
    public function groups()
    {
        return $this->hasMany('App\Modules\Group\Group', 'owner_id')->where('owner_type', $this->getClassName())->orderBy('position');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'product_id')->orderBy('position');
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
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','creator_id');
    }
}
