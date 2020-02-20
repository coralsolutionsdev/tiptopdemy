<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'default', 'position', 'show_on_edit', 'show_on_frontend', 'filterable', 'product_attribute_set_id', 'type'
    ];

    const TYPE_TEXT_FIELD = 0;
    const TYPE_RADIO = 1;
    const TYPE_CHECKBOX = 2;
    const TYPE_TIMESTAMP = 3;
    const TYPE_COLOR = 4;
    const TYPE_ARRAY = [
        self::TYPE_TEXT_FIELD => 'Text Field',
        self::TYPE_RADIO => 'Radio Button',
        self::TYPE_CHECKBOX => 'Checkbox',
        self::TYPE_TIMESTAMP => 'Date & Time',
        self::TYPE_COLOR => 'Color',
    ];
    /**
     * One-To-Many Relationship Method for accessing the options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany('App\ProductAttributeOption')->orderBy('position', 'asc');
    }
}
