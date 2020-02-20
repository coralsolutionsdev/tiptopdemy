<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeSet extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'position'
    ];
    /**
     * One-To-Many Relationship Method for accessing the attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany('App\ProductAttribute')->orderBy('position', 'asc')->with(['options']);
    }
}
