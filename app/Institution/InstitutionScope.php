<?php

namespace App\Institution;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstitutionScope extends Model
{
    use Sluggable;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'title','slug', 'description', 'user_id',
        'images','position', 'status'
    ];
    protected $casts = [
        'images' => 'array'
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
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /**
     * One-To-Many Relationship Method for accessing the attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
//        return $this->hasMany('App\Institutions\InstitutionScopeField')->orderBy('position', 'asc')->with(['options']);
        return $this->hasMany('App\Institution\InstitutionScopeField','scope_id')->orderBy('position', 'asc');
    }

}
