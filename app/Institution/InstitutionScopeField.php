<?php

namespace App\Institution;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstitutionScopeField extends Model
{
    use Sluggable;

    protected $fillable = [
        'title', 'slug', 'description', 'scope_id',
        'user_id', 'images', 'position', 'status',
        'type', 'default', 'levels'
    ];
    protected $casts = [
        'levels' => 'array'
    ];

    const TYPE_GENERAL = 0;
    const TYPE_ARRAY = [
        self::TYPE_GENERAL => 'General',
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

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', '']
            ]
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */
    /**
     * One-To-Many Relationship Method for accessing the options
     *
     * @return HasMany
     */
    public function options()
    {
        return $this->hasMany('App\Institution\InstitutionScopeFieldOption', 'field_id')->orderBy('position', 'asc');
    }
}
