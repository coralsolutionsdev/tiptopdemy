<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [
        'name', 'description', 'product_attribute_set_id'
    ];

    public function attributeSet()
    {
        return $this->belongsTo('App\ProductAttributeSet', 'product_attribute_set_id');
    }
}
