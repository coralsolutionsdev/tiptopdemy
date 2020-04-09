<?php

namespace App\Institution;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directorate extends Model
{
    use Sluggable;

    protected $fillable = ['title','slug' , 'description', 'items', 'user_id', 'country_id', 'position', 'default','status', 'default'];

    protected $casts = [
        'items' => 'array'
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
    public function sluggable()
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
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
