<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeSet extends Model
{
    use Sluggable;
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'position'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
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
