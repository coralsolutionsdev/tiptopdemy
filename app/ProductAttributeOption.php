<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'value', 'position', 'is_default', 'product_attribute_id'
    ];

}
